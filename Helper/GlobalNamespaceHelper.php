<?php declare(strict_types=1);

/**
 * @param mixed $object
 * @param bool  $verbose
 *
 * @return void
 */
function debug($object, bool $verbose = false): void
{
    if (!$verbose && is_object($object)) {
        echo 'Object of class ' . \get_class($object);
        return;
    }

    ob_start();
    \var_dump($object);
    $result = ob_get_clean();
    $result = preg_replace('/^(.*)GlobalNamespaceHelper\.php(.*)(\s*)/', '', $result);

    echo trim($result);
}

/**
 * @return void
 */
function trace(): void
{
    $trace = (new \Exception())->getTraceAsString();

    echo $trace;
}
