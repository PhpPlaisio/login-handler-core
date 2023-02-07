#!/bin/bash -e -x

cat test/ddl/0010_create_database.sql         | mysql -v -u root      -h 127.0.0.1
cat test/ddl/0020_create_user.sql             | mysql -v -u root      -h 127.0.0.1
cat test/ddl/0300_abc_auth_company.sql        | mysql -v -u root test -h 127.0.0.1
cat test/ddl/0300_abc_auth_user.sql           | mysql -v -u root test -h 127.0.0.1
cat test/ddl/0300_abc_auth_session.sql        | mysql -v -u root test -h 127.0.0.1
cat test/ddl/0300_abc_babel_word.sql          | mysql -v -u root test -h 127.0.0.1
cat lib/ddl/0100_create_tables.sql            | mysql -v -u root test -h 127.0.0.1
cat test/ddl/0310_abc_auth_login_response.sql | mysql -v -u root test -h 127.0.0.1

./bin/stratum -vv stratum test/etc/stratum.ini

./bin/phpunit
