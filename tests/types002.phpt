--TEST--
extended type support
--SKIPIF--
<?php
include "_skipif.inc";
if (!pq\Types::DEFINED) {
	die("skip pq\\Types::DEFINED == false\n");
}
?>
--INI--
date.timezone=UTC
--FILE--
<?php
echo "Test\n";

include "_setup.inc";

$c = new pq\Connection(PQ_DSN);
$r = $c->exec("SET timezone TO UTC; SELECT
NULL as null,
true as bool,
1::int2 as int2,
2::int4 as int4,
3::int8 as int8,
1.1::float4 as float4,
2.2::float8 as float8,
'2013-01-01'::date as date,
1::abstime as abstime,
'2013-01-01 01:01:01'::timestamp as timestamp,
'2013-01-01 01:01:01 UTC'::timestamptz as timestamptz,
array[array[1,2,3],array[4,5,6],array[NULL::int,NULL::int,NULL::int]] as intarray  
");
var_dump($r->fetchRow(pq\Result::FETCH_ASSOC));
?>
DONE
--EXPECTF--
Test
array(12) {
  ["null"]=>
  NULL
  ["bool"]=>
  bool(true)
  ["int2"]=>
  int(1)
  ["int4"]=>
  int(2)
  ["int8"]=>
  int(3)
  ["float4"]=>
  float(1.1)
  ["float8"]=>
  float(2.2)
  ["date"]=>
  object(pq\DateTime)#%d (4) {
    ["format"]=>
    string(5) "Y-m-d"
    ["date"]=>
    string(19) "2013-01-01 00:00:00"
    ["timezone_type"]=>
    int(3)
    ["timezone"]=>
    string(3) "UTC"
  }
  ["abstime"]=>
  object(pq\DateTime)#%d (4) {
    ["format"]=>
    string(11) "Y-m-d H:i:s"
    ["date"]=>
    string(19) "1970-01-01 00:00:01"
    ["timezone_type"]=>
    int(1)
    ["timezone"]=>
    string(6) "+00:00"
  }
  ["timestamp"]=>
  object(pq\DateTime)#%d (4) {
    ["format"]=>
    string(13) "Y-m-d H:i:s.u"
    ["date"]=>
    string(19) "2013-01-01 01:01:01"
    ["timezone_type"]=>
    int(3)
    ["timezone"]=>
    string(3) "UTC"
  }
  ["timestamptz"]=>
  object(pq\DateTime)#%d (4) {
    ["format"]=>
    string(14) "Y-m-d H:i:s.uO"
    ["date"]=>
    string(19) "2013-01-01 01:01:01"
    ["timezone_type"]=>
    int(1)
    ["timezone"]=>
    string(6) "+00:00"
  }
  ["intarray"]=>
  array(3) {
    [0]=>
    array(3) {
      [0]=>
      int(1)
      [1]=>
      int(2)
      [2]=>
      int(3)
    }
    [1]=>
    array(3) {
      [0]=>
      int(4)
      [1]=>
      int(5)
      [2]=>
      int(6)
    }
    [2]=>
    array(3) {
      [0]=>
      NULL
      [1]=>
      NULL
      [2]=>
      NULL
    }
  }
}
DONE