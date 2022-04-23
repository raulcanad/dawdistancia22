 /**
  * Generation du docblock
  *
  * @param Docblock $docblock
  * @return string
  */
 public function docblock($docblock)
 {
     // On verifie que le trait est bien présent
     $traits = class_uses($docblock);
     if (!array_search(Docblock::class, $traits)) {
         exc('la classe "' . get_class($docblock) . '" n\'utilise pas le trait "' . Docblock::class . '"');
     }
     $content = '/**' . PHP_EOL;
     $content .= '* ' . $docblock->getSummary() . PHP_EOL;
     $content .= '* ' . PHP_EOL;
     $content .= '* ' . str_replace(PHP_EOL, PHP_EOL . '* ', $docblock->getDescription()) . PHP_EOL;
     $content .= '* ' . PHP_EOL;
     foreach ($docblock->getTags() as $tag) {
         list($name, $value) = $tag;
         $content .= sprintf('* @%s %s', $name, $value) . PHP_EOL;
     }
     $content .= '*/';
     // on fait proprement mais bon!
     // @todo passer sur la version 3 de phpdocumentor
     $factory = new \phpDocumentor\Reflection\DocBlock($content);
     $serializer = new Serializer();
     $content = $serializer->getDocComment($factory) . PHP_EOL;
     return $content;
 }
