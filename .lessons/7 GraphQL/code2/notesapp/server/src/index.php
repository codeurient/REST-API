<?php
use GraphQL\GraphQL;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;

require_once __DIR__ . '/../vendor/autoload.php';

$fakeDatabase = [
    'notes' => [
        ['id' => '1', 'title' => 'İlk Qeyd', 'description' => 'Bu ilk qeyddir', 'authorId' => '1'],
        ['id' => '2', 'title' => 'İkinci Qeyd', 'description' => 'Bu ikinci qeyddir', 'authorId' => '2'],
    ],
    'authors' => [
        ['id' => '1', 'name' => 'Ali', 'age' => 30, 'photo' => null],
        ['id' => '2', 'name' => 'Veli', 'age' => 25, 'photo' => 'http://example.com/veli.jpg'],
    ]
];

// Define Author type
$authorType = new ObjectType([
    'name' => 'Author',
    'fields' => [
        'id' => ['type' => Type::id()],
        'name' => ['type' => Type::string()],
        'age' => ['type' => Type::int()],
        'photo' => ['type' => Type::string()],
    ]
]);

// Define Note type
$noteType = new ObjectType([
    'name' => 'Note',
    'fields' => [
        'id' => ['type' => Type::id()],
        'title' => ['type' => Type::string()],
        'description' => ['type' => Type::string()],
        'author' => [
            'type' => $authorType,
            'resolve' => function ($note) use ($fakeDatabase) {
                foreach ($fakeDatabase['authors'] as $author) {
                    if ($author['id'] === $note['authorId']) {
                        return $author;
                    }
                }
                return null;
            }
        ]
    ]
]);

// Define Query type
$queryType = new ObjectType([
    'name' => 'Query',
    'fields' => [
        'notes' => [
            'type' => Type::listOf($noteType),
            'resolve' => function () use ($fakeDatabase) {
                return $fakeDatabase['notes'];
            }
        ]
    ]
]);

// Create schema
$schema = new Schema([
    'query' => $queryType
]);

try {
    $input = json_decode(file_get_contents('php://input'), true);
    $query = $input['query'] ?? '';
    $variables = $input['variables'] ?? null;

    $result = GraphQL::executeQuery(
        $schema,
        $query,
        null,
        null,
        $variables
    )->setErrorFormatter(function ($e) {
        return [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ];
    });
    
    header('Content-Type: application/json');
    echo json_encode($result->toArray());
    
} catch (\Exception $e) {
    header('Content-Type: application/json');
    echo json_encode(['errors' => [['message' => $e->getMessage()]]]);
}