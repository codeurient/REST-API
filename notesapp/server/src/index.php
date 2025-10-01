<?php
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true"); // If you need to send cookies or authentication headers

use GraphQL\GraphQL;
use GraphQL\Utils\BuildSchema;
require_once __DIR__ . '/../vendor/autoload.php';

$fakeDatabase = [
    'notes' => [
        ['id' => '1', 'title' => 'İlk Qeyd', 'description' => 'Bu ilk qeyddir', 'authorId' => '1'],
        ['id' => '2', 'title' => 'İkinci Qeyd', 'description' => 'Bu ikinci qeyddir', 'authorId' => '2'],
    ],
    'authors' => [
        ['id' => '1', 'name' => 'Ali', 'age' => 30,  'photo' => 'https://i.redd.it/becdb8b5twt01.jpg'],
        ['id' => '2', 'name' => 'Veli', 'age' => 25, 'photo' => 'https://images5.alphacoders.com/423/thumb-1920-423529.jpg'],
    ]
];

$schemaContent = file_get_contents(__DIR__ . '/../graphql/schema.graphql');

$typeConfigDecorator = function ($typeConfig) use ($fakeDatabase) {
    $name = $typeConfig['name'] ?? '';
    
    if ($name === 'Note') {
        $originalFields = $typeConfig['fields'];
        $typeConfig['fields'] = function () use ($originalFields, $fakeDatabase) {

            $fields = $originalFields ? $originalFields() : [];
            
            if (isset($fields['author'])) {
                $fields['author']['resolve'] = function ($note) use ($fakeDatabase) {
                    foreach ($fakeDatabase['authors'] as $author) {
                        if ($author['id'] === $note['authorId']) {
                            return $author;
                        }
                    }
                    return null;
                };
            }
            return $fields;
        };
    }
    return $typeConfig;
};

$schema = BuildSchema::build($schemaContent, $typeConfigDecorator);

$rootValue = [
    'notes' => function () use ($fakeDatabase) {
        return $fakeDatabase['notes'];
    }
];

try {
    $input = json_decode(file_get_contents('php://input'), true);
    $query = $input['query'] ?? '';
    $variables = $input['variables'] ?? null;

    $result = GraphQL::executeQuery(
        $schema,
        $query,
        $rootValue,
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