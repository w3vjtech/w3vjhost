# Databases

To manage your databases, navigate to the **DB <i class="fas fa-fw fa-database"></i>** tab.

## Adding a database

1. Click the **<i class="fas fa-fw fa-plus-circle"></i> Add Database** button.
2. Fill out the fields. The name and username will be prefixed with `user_`.
3. Optionally, provide an email address where the login details will be sent.
4. Click the **<i class="fas fa-fw fa-save"></i> Save** button in the top right.

Under **Advanced Options**, you are able to select the host (`localhost` by default) and charset (`utf8` by default).

## Editing a database

1. Hover over the database you want to edit.
2. Click the <i class="fas fa-fw fa-pencil-alt"><span class="visually-hidden">edit</span></i> icon on the right of the database’s name. If you don’t want to change the password, keep the password field empty.

## Accessing a database

By default, **phpMyAdmin** and **phpPgAdmin** are accessible at `https://hostname.domain.tld/phpmyadmin` and `https://hostname.domain.tld/phppgadmin` respectively. You can also click the **<i class="fas fa-fw fa-database"></i> phpMyAdmin** and **<i class="fas fa-fw fa-database"></i> phpPgAdmin** buttons in the **DB <i class="fas fa-fw fa-database"></i>** tab.

For MySQL databases, if **phpMyAdmin Single Sign On** is enabled, hovering a database will show an <i class="fas fa-fw fa-sign-in-alt"><span class="visually-hidden">phpMyAdmin</span></i> icon. Click it to login to **phpMyAdmin** directly.

## NoSQL databases

If MongoDB or Redis is installed and managed by Hestia, the **Databases** page also shows a separate NoSQL section. Create a named entry there and save the generated password immediately; passwords are shown only once, when an entry is created or its password is reset.

- Only entries created through Hestia appear in this section. Existing MongoDB databases and Redis data are not imported automatically.
- On existing Redis installations, an administrator must run `v-configure-sys-redis-acl` once before Redis namespaces can be managed. This command restarts Redis.
- Check MongoDB Community's SSPL terms before offering it to hosting customers.
- MongoDB entries have a dedicated database user with read/write access to that database only.
- Redis entries use a dedicated ACL user restricted to a key prefix. They are namespaces, not separately created Redis database indexes; applications must use the displayed key prefix for their keys.
- Both services listen on localhost. Applications on another server need an SSH tunnel to connect.
- Deleting an entry permanently removes its MongoDB database or all Redis keys in its namespace, and removes its credentials.
- NoSQL entries are **not included in Hestia user backups**. Back them up separately before relying on them.
- NoSQL storage is not included in Hestia per-user disk usage or quotas. Redis memory limits apply server-wide.

## Suspending a database

1. Hover over the database you want to suspend.
2. Click the <i class="fas fa-fw fa-pause"><span class="visually-hidden">suspend</span></i> icon on the right of the database’s name.
3. To unsuspend it, click the <i class="fas fa-fw fa-play"><span class="visually-hidden">unsuspend</span></i> icon on the right of the database’s name.

## Deleting a database

1. Hover over the database you want to delete.
2. Click the <i class="fas fa-fw fa-trash"><span class="visually-hidden">delete</span></i> icon on the right of the database’s name. Both the database user and the database will get deleted.
