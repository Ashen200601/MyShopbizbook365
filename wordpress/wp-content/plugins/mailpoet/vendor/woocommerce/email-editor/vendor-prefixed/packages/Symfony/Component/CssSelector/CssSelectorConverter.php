<?php
namespace Automattic\WooCommerce\EmailEditorVendor\Symfony\Component\CssSelector;
if (!defined('ABSPATH')) exit;
use Automattic\WooCommerce\EmailEditorVendor\Symfony\Component\CssSelector\Parser\Shortcut\ClassParser;
use Automattic\WooCommerce\EmailEditorVendor\Symfony\Component\CssSelector\Parser\Shortcut\ElementParser;
use Automattic\WooCommerce\EmailEditorVendor\Symfony\Component\CssSelector\Parser\Shortcut\EmptyStringParser;
use Automattic\WooCommerce\EmailEditorVendor\Symfony\Component\CssSelector\Parser\Shortcut\HashParser;
use Automattic\WooCommerce\EmailEditorVendor\Symfony\Component\CssSelector\XPath\Extension\HtmlExtension;
use Automattic\WooCommerce\EmailEditorVendor\Symfony\Component\CssSelector\XPath\Translator;
class CssSelectorConverter
{
 private $translator;
 private $cache;
 private static $xmlCache = [];
 private static $htmlCache = [];
 public function __construct(bool $html = true)
 {
 $this->translator = new Translator();
 if ($html) {
 $this->translator->registerExtension(new HtmlExtension($this->translator));
 $this->cache = &self::$htmlCache;
 } else {
 $this->cache = &self::$xmlCache;
 }
 $this->translator
 ->registerParserShortcut(new EmptyStringParser())
 ->registerParserShortcut(new ElementParser())
 ->registerParserShortcut(new ClassParser())
 ->registerParserShortcut(new HashParser())
 ;
 }
 public function toXPath(string $cssExpr, string $prefix = 'descendant-or-self::')
 {
 return $this->cache[$prefix][$cssExpr] ?? $this->cache[$prefix][$cssExpr] = $this->translator->cssToXPath($cssExpr, $prefix);
 }
}
