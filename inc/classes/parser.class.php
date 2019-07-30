<?php

use Symfony\Component\DomCrawler\Crawler;
use Masterminds\HTML5;

class Parser
{
    /**
     * The html
     *
     * @var string
     */
    protected $html;

    /**
     * Whitelist of allowed elements
     *
     * @var array
     */
    public $elementsWhitelist = [];

    /**
     * The array of nodes to remove
     *
     * @var array
     */
    protected $removeNodes;

    /**
     * Share dependencies
     *
     * @param string $html
     */
    public function __construct($html = '')
    {
        $this->elementsWhitelist = [
            'div' => [
                'attributes' => [
                    'class',
                    'style',
                    'id',
                ]
            ],
            'a' => [
                'attributes' => [
                    'class',
                    'href',
                    'id',
                    'style',
                ],
            ],
            'b' => [
                'attributes' => [
                    'class',
                    'id',
                    'style',
                ],
            ],
            'blockquote' => [
                'attributes' => [
                    'class',
                    'id',
                    'style',
                ],
            ],
            'br' => [
                'attributes' => [
                    'class',
                    'id',
                    'style',
                ],
            ],
            'em' => [
                'attributes' => [
                    'class',
                    'id',
                    'style',
                ],
            ],
            'font' => [
                'attributes' => [
                    'class',
                    'id',
                    'size',
                    'style',
                    'color',
                ],
            ],
            'hr' => [
                'attributes' => [
                    'class',
                    'id',
                    'style',
                ],
            ],
            'h1' => [
                'attributes' => [
                    'class',
                    'id',
                    'style',
                ],
            ],
            'h2' => [
                'attributes' => [
                    'class',
                    'id',
                    'style',
                ],
            ],
            'h3' => [
                'attributes' => [
                    'class',
                    'id',
                    'style',
                ],
            ],
            'h4' => [
                'attributes' => [
                    'class',
                    'id',
                    'style',
                ],
            ],
            'h5' => [
                'attributes' => [
                    'class',
                    'id',
                    'style',
                ],
            ],
            'h6' => [
                'attributes' => [
                    'class',
                    'id',
                    'style',
                ],
            ],
            'i' => [
                'attributes' => [
                    'class',
                    'id',
                    'style',
                ],
            ],
            'img' => [
                'attributes' => [
                    'class',
                    'id',
                    'style',
                    'src',
                ],
            ],
            'li' => [
                'attributes' => [
                    'class',
                    'id',
                    'style',
                ],
            ],
            'ol' => [
                'attributes' => [
                    'class',
                    'id',
                    'style',
                ],
            ],
            'p' => [
                'attributes' => [
                    'class',
                    'id',
                    'style',
                ],
            ],
            'pre' => [
                'attributes' => [
                    'class',
                    'id',
                    'style',
                ],
            ],
            's' => [
                'attributes' => [
                    'class',
                    'id',
                    'style',
                ],
            ],
            'span' => [
                'attributes' => [
                    'class',
                    'id',
                    'style',
                ],
            ],
            'strong' => [
                'attributes' => [
                    'class',
                    'id',
                    'style',
                ],
            ],
            'table' => [
                'attributes' => [
                    'class',
                    'id',
                    'style',
                ],
            ],
            'tbody' => [
                'attributes' => [
                    'class',
                    'id',
                    'style',
                ],
            ],
            'td' => [
                'attributes' => [
                    'class',
                    'id',
                    'style',
                ],
            ],
            'th' => [
                'attributes' => [
                    'class',
                    'id',
                    'style',
                ],
            ],
            'thead' => [
                'attributes' => [
                    'class',
                    'id',
                    'style',
                ],
            ],
            'tr' => [
                'attributes' => [
                    'class',
                    'id',
                    'style',
                ],
            ],
            'u' => [
                'attributes' => [
                    'class',
                    'id',
                    'style',
                ],
            ],
            'ul' => [
                'attributes' => [
                    'class',
                    'id',
                    'style',
                ],
            ],
        ];
        $this->html = $html;
    }

    /**
     * Load html from file
     *
     * @param  string $path
     * @return Void
     */
    public function loadFromFile($path)
    {
        $this->html = file_get_contents($path);
    }

    /**
     * Load html from url
     *
     * @param  string $url
     * @param  integer $connectTimeout
     * @param  integer $executionTimeout
     * @return Void
     */
    public function loadFromUrl($url, $connectTimeout = 5, $executionTimeout = 5)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $connectTimeout);
        curl_setopt($curl, CURLOPT_TIMEOUT, $executionTimeout);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $this->html = curl_exec($curl);
        curl_close($curl);
    }

    /**
     * Parse html
     *
     * @param  string $encoding
     * @return Void
     */
    public function parseHtml($encoding = 'utf-8')
    {
        if (strlen($this->html) == 0)
            return '';

        $this->html = '<p>' . $this->html . '</p>';
        //$this->html = nl2br($this->html, false);

        $html5 = new HTML5;
        $doc = $html5->loadHTML($this->html);

        $doc = $this->filterNodes($doc);
        $this->removeNodes();

        $this->html = $html5->saveHTML($doc);

        // We only want the content of the body returned.
        $this->html = preg_replace('~<(?:!DOCTYPE|/?(?:html|head|body))[^>]*>\s*~i', '', $this->html);

        // Removes empty newlines.
        //$this->html = preg_replace('/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/', '', $this->html);

        return trim($this->html);
    }

    /**
     * Fetch child nodes
     *
     * @param  mixed $node
     * @return mixed
     */
    protected function filterNodes($node)
    {
        if ($node->hasChildNodes()) {
            foreach ($node->childNodes as $childNode) {
                if ($childNode instanceof DOMElement) {
                    if (!isset($this->elementsWhitelist[$childNode->tagName]) && !in_array($childNode->tagName, ['html', 'body'])) {
                        $this->removeNodes[] = $childNode;

                        continue;
                    }

                    $this->removeDisallowedAttributes($childNode);
                }

                $this->filterNodes($childNode);
            }
        }

        return $node;
    }

    /**
     * Remove nodes
     *
     * @return Void
     */
    public function removeNodes()
    {
        if (!empty($this->removeNodes)) {
            foreach ($this->removeNodes as $node) {
                $node->parentNode->removeChild($node);
            }
        }

        $this->removeNodes = [];
    }

    /**
     * Remove disallowed attributes on node
     *
     * @param  DomNode $node
     * @return Void
     */
    protected function removeDisallowedAttributes($node)
    {
        if ($node->hasAttributes()) {

            if (isset($this->elementsWhitelist[$node->tagName])) {
                $elementAttributes = $this->elementsWhitelist[$node->tagName]['attributes'];
                $length = $node->attributes->length;
                $removeableAttributes = [];

                for ($i = 0; $i < $length; $i++) {
                    $item = $node->attributes->item($i);

                    if (!$item) {
                        continue;
                    }

                    $attrName  = $item->name;
                    $attrValue = $item->value;
                    $position  = array_search('data-*', $elementAttributes);

                    if ($attrName == 'href' && stripos($attrValue, 'javascript:') !== false) {
                        $attrValue = substr($attrValue, 11);
                        $node->setAttribute('href', $attrValue);
                    }

                    if (!in_array($attrName, $elementAttributes)) {
                        if ($position === false && !fnmatch($elementAttributes[$position], $attrName)) {
                            $removeableAttributes[] = $attrName;
                        }
                    }
                }

                if (!empty($removeableAttributes)) {
                    foreach($removeableAttributes as $attrName) {
                        $node->removeAttribute($attrName);
                    }
                }
            }
        }
    }
}