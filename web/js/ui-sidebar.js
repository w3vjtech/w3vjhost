/* Registered before Alpine starts; keeps Hestia's existing navigation selectors. */
document.addEventListener('alpine:init', () => {
 Alpine.data('w3vjSidebar', () => ({
  collapsed: false, open: false, mobile: false,
  init() {
   this.sidebar = this.$el.querySelector('#w3vj-sidebar');
   this.opener = this.$el.querySelector('.w3vj-drawer-toggle');
   this.toggle = this.sidebar.querySelector('.w3vj-sidebar-toggle');
   this.backdrop = this.$el.querySelector('.w3vj-sidebar-backdrop');
   this.media = matchMedia('(max-width: 767px)');
   this.mobile = this.media.matches;
   try { this.collapsed = localStorage.getItem('w3vj-sidebar-collapsed') === 'true'; } catch {}
   this.$watch('collapsed', () => this.render());
   this.$watch('open', () => this.render());
   this.$watch('mobile', () => this.render());
   this.resize = () => { const inside = this.sidebar.contains(document.activeElement); this.mobile = this.media.matches; this.open = false; this.$nextTick(() => { if (inside && this.mobile) this.opener.focus(); }); };
   this.media.addEventListener('change', this.resize);
   this.hash = () => this.updateSection();
   window.addEventListener('hashchange', this.hash);
   document.body.classList.add('w3vj-sidebar-ready');
   this.sidebar.querySelectorAll('.main-menu-item-link.active').forEach(link => link.setAttribute('aria-current', 'page'));
   this.updateSection(); this.render();
  },
  openDrawer() { this.open = true; this.$nextTick(() => this.toggle.focus()); },
  closeDrawer() { this.open = false; this.$nextTick(() => this.opener.focus()); },
  toggleSidebar() {
   if (this.mobile) return this.closeDrawer();
   this.collapsed = !this.collapsed;
   try { localStorage.setItem('w3vj-sidebar-collapsed', String(this.collapsed)); } catch {}
  },
  render() {
   document.body.classList.toggle('w3vj-sidebar-collapsed', !this.mobile && this.collapsed);
   document.body.classList.toggle('w3vj-sidebar-open', this.mobile && this.open);
   this.opener.setAttribute('aria-expanded', String(this.mobile && this.open));
   this.toggle.setAttribute('aria-expanded', String(this.mobile ? this.open : !this.collapsed));
   this.toggle.setAttribute('aria-label', this.mobile || !this.collapsed ? this.toggle.dataset.collapse : this.toggle.dataset.expand);
   this.toggle.title = this.toggle.getAttribute('aria-label');
   this.backdrop.hidden = !(this.mobile && this.open);
   this.sidebar.inert = this.mobile && !this.open;
   document.querySelectorAll('.top-bar, .app-content, .app-footer').forEach(element => { element.inert = this.mobile && this.open; });
  },
  keydown(event) {
   if (!this.mobile || !this.open) return;
   if (event.key === 'Escape') { event.preventDefault(); this.closeDrawer(); }
   if (event.key !== 'Tab') return;
   const items = [...this.sidebar.querySelectorAll('a[href],button:not([disabled])')];
   const first = items[0], last = items[items.length - 1];
   if (event.shiftKey && document.activeElement === first) { event.preventDefault(); last.focus(); }
   else if (!event.shiftKey && document.activeElement === last) { event.preventDefault(); first.focus(); }
  },
  updateSection() {
   const link = this.sidebar.querySelector('.w3vj-db-submenu a');
   if (!link) return;
   const selected = location.pathname === '/list/db/' && ['#nosql', '#redis'].includes(location.hash);
   link.classList.toggle('active', selected);
   if (selected) link.setAttribute('aria-current', 'location'); else link.removeAttribute('aria-current');
  },
  destroy() { this.media.removeEventListener('change', this.resize); window.removeEventListener('hashchange', this.hash); }
 }));
 if (window.lucide) lucide.createIcons({ attrs: { 'stroke-width': 1.75, 'aria-hidden': 'true' } });
});

/* Keep icon hooks used by Hestia while rendering Lucide, without icon font CSS. */
document.addEventListener('DOMContentLoaded', () => {
 if (!window.lucide) return;
 const aliases = {'bars':'menu','gear':'settings','circle-question':'circle-help','question-circle':'circle-help','info-circle':'info','circle-exclamation':'circle-alert','triangle-exclamation':'triangle-alert','xmark':'x','circle-xmark':'circle-x','circle-user':'circle-user-round','user-tie':'user-round','earth-americas':'globe','earth-europe':'globe','envelopes-bulk':'mails','envelope-open-text':'mail-open','book-atlas':'notebook-tabs','file-zipper':'archive','box-open':'package-open','circle-notch':'loader-circle','floppy-disk':'save','right-left':'arrow-left-right','right-from-bracket':'log-out','right-to-bracket':'log-in','arrow-rotate-left':'rotate-ccw','arrow-rotate-right':'rotate-cw','arrows-rotate':'refresh-cw','circle-left':'circle-arrow-left','circle-up':'circle-arrow-up','magnifying-glass':'search','square-up-right':'external-link','clock-rotate-left':'history','chart-bar':'chart-column','code-branch':'git-branch','cube':'box','cubes':'boxes','clone':'copy','ethernet':'network','memory':'memory-stick','microchip':'cpu','paint-brush':'paintbrush','shield-halved':'shield-half','magic':'wand-sparkles','exclamation':'triangle-alert','bell-slash':'bell-off','file-arrow-down':'file-down','flask':'flask-conical','paper-plane':'send','puzzle-piece':'puzzle','stop':'square','toggle-off':'toggle-left','toggle-on':'toggle-right'};
 // createIcons() scans the whole document, so run it once per frame, not once per icon
 let queued = false;
 function flush() { queued = false; lucide.createIcons({ attrs: { 'aria-hidden':'true', 'class':'size-4 shrink-0', 'stroke-width':1.75 } }); }
 function render(element) {
  const cls = [...element.classList].find(name => name.startsWith('fa-') && name !== 'fa-spin');
  if (!cls || element.dataset.renderedIcon === cls) return;
  element.dataset.renderedIcon = cls;
  const icon = document.createElement('span'); icon.setAttribute('data-lucide', aliases[cls.slice(3)] || cls.slice(3));
  element.replaceChildren(icon); element.classList.add('inline-flex','shrink-0','align-middle');
  if (element.classList.contains('fa-spin')) element.classList.add('animate-spin','motion-reduce:animate-none');
  if (!queued) { queued = true; requestAnimationFrame(flush); }
 }
 document.querySelectorAll('i.fas,i.fa').forEach(render);
 if (queued) flush();
 new MutationObserver(records => {
  for (const record of records) {
   if (record.type === 'attributes' && record.target.matches('i.fas,i.fa')) render(record.target);
   for (const node of record.addedNodes) if (node.nodeType === 1) {
    if (node.matches('i.fas,i.fa')) render(node);
    node.querySelectorAll('i.fas,i.fa').forEach(render);
   }
  }
 }).observe(document.body,{subtree:true,childList:true,attributes:true,attributeFilter:['class']});
});
