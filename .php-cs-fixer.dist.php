<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude('node_modules');

$config = new PhpCsFixer\Config();

return $config->setRules([
    '@Symfony' => true,
    'array_indentation' => true,
    // 'binary_operator_spaces' => ['operators' => ['|' => 'no_space']],
    'concat_space' => ['spacing' => 'one'],
    'declare_strict_types' => true, // risky
    // 'echo_tag_syntax' => ['format' => 'short'],
    'escape_implicit_backslashes' => true,
    'function_declaration' => true,
    'method_chaining_indentation' => true,
    'no_mixed_echo_print' => ['use' => 'echo'],
    // 'not_operator_with_successor_space' => true,
    'phpdoc_align' => [
        'align' => 'left',
        'tags' => ['param', 'property', 'return', 'throws', 'type', 'var'],
    ],
    'ternary_to_null_coalescing' => true,
    'yoda_style' => false,
])->setRiskyAllowed(true)->setFinder($finder);
