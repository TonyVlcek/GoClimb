<?php
use GoClimb\Model\Entities\Article;
use GoClimb\Model\Entities\User;
use GoClimb\Model\Rest\Mappers\ArticleMapper;
use Tester\Assert;


require __DIR__ . '/../../../../../bootstrap.php';

$article = new Article;
$user = new User;
$article->setAuthor($user);

$data = [
	'id' => NULL,
	'name' => 'Test article',
	'content' => 'Test content',
	'author' => [
		'id' => $user->getId(),
		'name' => $user->getFullName(),
	],
	'published' => FALSE,
	'publishedDate' => NULL,
];

foreach ($data as $field => $value) {
	if ($field === 'id') {
		continue;
	} elseif (in_array($field, ['name', 'content'], TRUE)) {
		$method = 'set' . ucfirst($field);
		$article->$method($value);
	}
}

Assert::type('array', $serialized = ArticleMapper::map($article));
Assert::equal($data, $serialized);
