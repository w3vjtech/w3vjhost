#=========================================================================#
# W3VJ Node.js Application Template                                       #
# DO NOT MODIFY THIS FILE! CHANGES WILL BE LOST WHEN REBUILDING DOMAINS   #
#=========================================================================#

[Unit]
Description=W3VJ Node.js %backend_version% application for %domain%
After=network.target

[Service]
Type=simple
User=%user%
Group=%user%
Slice=user-%uid%.slice
WorkingDirectory=%app_dir%
Environment=NODE_ENV=production
Environment=PORT=%app_socket%
Environment=HOME=%app_dir%
Environment=PATH=/opt/w3vj/nodejs/%backend_version%/bin:/usr/local/bin:/usr/bin:/bin
ExecStartPre=+/usr/bin/install -d -o %user% -g www-data -m 2750 %socket_dir%
ExecStartPre=-/bin/rm -f %app_socket%
ExecStart=/opt/w3vj/nodejs/%backend_version%/bin/node %app_entry%
Restart=on-failure
RestartSec=5
UMask=0007
StandardOutput=append:%app_log%
StandardError=inherit

NoNewPrivileges=yes
PrivateTmp=yes
PrivateDevices=yes
ProtectSystem=strict
ProtectHome=tmpfs
BindPaths=%app_dir%
ReadWritePaths=-%socket_dir%
ProtectKernelTunables=yes
ProtectKernelModules=yes
ProtectControlGroups=yes
RestrictSUIDSGID=yes
LockPersonality=yes

[Install]
WantedBy=multi-user.target
