# Sybase/SAP ASE Database
This package allows you to connect your PHP applications to Sybase/SAP ASE database.

This will assume you already installed php sybase_ct extension using Sybase client libraries or FreeTDS libraries.

### Usage:

First, create a new "Capsule" manager instance. Capsule aims to make configuring the library for usage outside of the Laravel framework as easy as possible.

```PHP
use Tlangelani\Database\Sybase;

// initialize sybase with credentials.
// NB: DEV_HOST must be configured on your sybase interfaces file, or freetds conf file.
$sybase = new Sybase('DEV_HOST', 'DEV_DB', 'USER', 'PASS');

// run query
$users = $sybase->query('SELECT * FROM users');

// run query with and return data as object
$users = $sybase->query('SELECT * FROM users', 'OBJ');

print_r( $users );

```