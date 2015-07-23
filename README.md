# Sybase/SAP ASE Database
This package allows you to connect your PHP applications to Sybase/SAP ASE database.

This will assume you already installed PHP [sybase_ct](http://php.net/manual/en/book.sybase.php) extension using Sybase client libraries or [FreeTDS](http://www.freetds.org/) libraries.

### Usage:

```PHP

// add Sybase class to your project, you can use composer autoload as well
require 'Sybase.php';

use Tlangelani\Database\Sybase;

// initialize Sybase with credentials.
// NB: DEV_HOST must be configured in your Sybase interfaces file, or freetds conf file.
$sybase = new Sybase('DEV_HOST', 'DEV_DB', 'USER', 'PASS');

// list databases
$dbs = $sybase->getDB();

// list database tables
$tables = $sybase->getTables('live_db');

// list table columns
$columns = $sybase->getTableColumns('users');

// run query
$users = $sybase->query('SELECT * FROM users');

// run query with and return data as object
$users = $sybase->query('SELECT * FROM users', 'OBJ');


```