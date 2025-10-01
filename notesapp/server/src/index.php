<?php
use GraphQL\GraphQL;
use GraphQL\Utils\BuildSchema;

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

// Read schema from file
$schemaContent = file_get_contents(__DIR__ . '/../graphql/schema.graphql');

// Create type config decorator to add resolvers
$typeConfigDecorator = function ($typeConfig) use ($fakeDatabase) {
    $name = $typeConfig['name'] ?? '';
    
    if ($name === 'Note') {
        // Store the original fields function
        $originalFields = $typeConfig['fields'];
        
        $typeConfig['fields'] = function () use ($originalFields, $fakeDatabase) {
            // Get the original fields
            $fields = $originalFields ? $originalFields() : [];
            
            // Add author resolver to Note fields
            if (isset($fields['author'])) {
                $fields['author']['resolve'] = function ($note) use ($fakeDatabase) {
                    // Find author by authorId
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

// Build schema with custom resolvers
$schema = BuildSchema::build($schemaContent, $typeConfigDecorator);

// Root value for top-level queries
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