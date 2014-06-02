--TEST--
Test function object
--SKIPIF--
<?php if (!extension_loaded("jitfu")) die("skip JITFu not loaded"); ?>
--FILE--
<?php
use JITFu\Context;
use JITFu\Type;
use JITFu\Signature;
use JITFu\Func;
use JITFu\Builder;

$context = new Context();
$context->start();

$int      = new Type(JIT_TYPE_INT);

/* int function(int n); */
$sig      = new Signature($int, [$int]);

$function = new Func($context, $sig);

var_dump($function->isCompiled());

$builder = new Builder($function);

/* return n; */
$builder->doReturn(
	$function->getParameter(0));

$function->compile();

var_dump(
	$function->isCompiled(), 
	is_callable($function),
	$function(10), $function(20), $function(30));
?>
--EXPECT--
bool(false)
bool(true)
bool(true)
int(10)
int(20)
int(30)