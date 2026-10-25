/* Progressive presentation: original links, forms and event handlers stay intact. */
(() => {
 'use strict';
 document.querySelectorAll('.units-table-row-actions').forEach((list, index) => {
  const items = [...list.children];
  if (items.length < 3) return;
  const holder = document.createElement('li');
  holder.className = 'w3vj-actions-more relative';
  const details = document.createElement('details');
  const summary = document.createElement('summary');
  summary.textContent = '•••';
  summary.className = 'flex size-8 cursor-pointer items-center justify-center rounded-md border border-slate-200 bg-white text-slate-600';
  summary.setAttribute('aria-label', 'More actions');
  const menu = document.createElement('ul');
  menu.className = 'absolute right-0 top-9 z-40 min-w-44 max-w-[80vw] rounded-lg border border-slate-200 bg-white p-2 shadow-lg [&_.u-hide-desktop]:inline!';
  menu.id = `w3vj-actions-${index}`;
  summary.setAttribute('aria-controls', menu.id);
  items.slice(1).forEach(item => {
   const link = item.querySelector('a');
   if (link && !link.textContent.trim()) {
    const label = document.createElement('span');
    label.textContent = link.title || link.getAttribute('aria-label') || 'Action';
    link.append(label);
   }
   menu.append(item);
  });
  details.append(summary, menu); holder.append(details); list.append(holder);
  details.addEventListener('toggle', () => {
   summary.setAttribute('aria-expanded', String(details.open));
   if (details.open) document.querySelectorAll('.w3vj-actions-more details[open]').forEach(other => { if (other !== details) other.open = false; });
  });
  details.addEventListener('keydown', event => {
   if (event.key === 'Escape') { details.open = false; summary.focus(); event.stopPropagation(); }
  });
  menu.addEventListener('click', event => { if (event.target.closest('a')) details.open = false; });
 });
 document.addEventListener('click', event => {
  document.querySelectorAll('.w3vj-actions-more details[open]').forEach(details => { if (!details.contains(event.target)) details.open = false; });
 });
 const nosql = document.getElementById('nosql');
 if (!nosql) return;
 const container = nosql.parentElement;
 const sqlTable = [...container.children].find(element => element.classList.contains('units-table'));
 if (!sqlTable) return;
 const sqlFooter = sqlTable.nextElementSibling;
 const tabs = document.createElement('div');
 tabs.className = 'w3vj-db-tabs flex gap-2 py-4'; tabs.setAttribute('role', 'tablist'); tabs.setAttribute('aria-label', 'Database service');
 const sqlPanel = document.createElement('section');
 sqlTable.before(tabs, sqlPanel); sqlPanel.append(sqlTable);
 if (sqlFooter?.classList.contains('units-table-footer')) sqlPanel.append(sqlFooter);
 sqlPanel.id = 'w3vj-sql-panel'; sqlPanel.setAttribute('role', 'tabpanel');
 nosql.setAttribute('role', 'tabpanel');
 const buttons = ['SQL', 'MongoDB', 'Redis'].map((label, index) => {
  const button = document.createElement('button'); button.type = 'button'; button.textContent = label;
  button.id = `w3vj-db-tab-${index}`; button.className = 'rounded-lg border border-slate-200 bg-white px-4 py-2 font-semibold text-slate-600 aria-selected:border-blue-300 aria-selected:bg-blue-50 aria-selected:text-blue-700'; button.setAttribute('role', 'tab'); button.setAttribute('aria-controls', index ? 'nosql' : sqlPanel.id);
  tabs.append(button); return button;
 });
 const empty = document.createElement('p'); empty.className = 'w3vj-service-empty'; empty.hidden = true; nosql.append(empty);
 function select(index) {
  buttons.forEach((button, i) => { button.setAttribute('aria-selected', String(i === index)); button.tabIndex = i === index ? 0 : -1; });
  sqlPanel.hidden = index !== 0; nosql.hidden = index === 0;
  const sqlTools = document.querySelector('.toolbar-right');
  if (sqlTools) sqlTools.hidden = index !== 0;
  (index ? nosql : sqlPanel).setAttribute('aria-labelledby', buttons[index].id);
  const service = index === 1 ? 'mongodb' : 'redis';
  nosql.querySelectorAll('[data-nosql-service]').forEach(element => { element.hidden = element.dataset.nosqlService !== service; });
  const table = nosql.querySelector('.units-table');
  const hasRows = !!nosql.querySelector(`.units-table-row[data-nosql-service="${service}"]`);
  if (table) table.hidden = !hasRows;
  empty.hidden = !table || hasRows;
  empty.textContent = `No managed ${buttons[index].textContent} entries.`;
 }
 buttons.forEach((button,index) => {
  button.addEventListener('click', () => { location.hash = ['sql','nosql','redis'][index]; select(index); });
  button.addEventListener('keydown', event => {
   let next;
   if (event.key === 'ArrowRight') next = (index + 1) % 3;
   if (event.key === 'ArrowLeft') next = (index + 2) % 3;
   if (event.key === 'Home') next = 0;
   if (event.key === 'End') next = 2;
   if (next !== undefined) { event.preventDefault(); buttons[next].click(); buttons[next].focus(); }
  });
 });
 const fromHash = () => select(location.hash === '#redis' ? 2 : location.hash === '#nosql' ? 1 : 0);
 window.addEventListener('hashchange', fromHash); fromHash();
})();
