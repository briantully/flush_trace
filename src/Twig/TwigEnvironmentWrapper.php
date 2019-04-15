<?php

namespace Drupal\flush_trace\Twig;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\PhpStorage\PhpStorageFactory;
use Drupal\Core\State\StateInterface;
use Drupal\Core\Template\TwigEnvironment;
use Drupal\Core\Utility\Error;

/**
 * Class TwigEnvironmentWrapper.
 */
/**
 * A class that defines a Twig environment for Drupal.
 *
 * Instances of this class are used to store the configuration and extensions,
 * and are used to load templates from the file system or other locations.
 *
 * @see core\vendor\twig\twig\lib\Twig\Environment.php
 */
class TwigEnvironmentWrapper extends TwigEnvironment {

  /**
   * Original service object.
   *
   * @var Drupal\Core\Template\TwigEnvironment
   */
  protected $twigEnvironment;

  /**
   * Key name of the Twig cache prefix metadata key-value pair in State.
   */
  const CACHE_PREFIX_METADATA_KEY = 'twig_extension_hash_prefix';

  /**
   * The cache service.
   *
   * @var \Drupal\Core\Cache\CacheBackendInterface
   */
  protected $cache;

  /**
   * The state service.
   *
   * @var \Drupal\Core\State\StateInterface
   */
  protected $state;

  /**
   * The loader service.
   *
   * @var \Twig_LoaderInterface
   */
  protected $loader;

  /**
   * Static cache of template classes.
   *
   * @var array
   */
  protected $templateClasses;

  protected $twigCachePrefix = '';

  /**
   * TwigEnvironmentWrapper constructor.
   *
   * @param \Drupal\Core\Template\TwigEnvironment $twig_environment
   *   The original twig environment.
   * @param string $root
   *   The app root.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache
   *   The cache bin.
   * @param string $twig_extension_hash
   *   The Twig extension hash.
   * @param \Drupal\Core\State\StateInterface $state
   *   The state service.
   * @param \Twig_LoaderInterface $loader
   *   The Twig loader or loader chain.
   * @param array $options
   *   The options for the Twig environment.
   */
  public function __construct(TwigEnvironment $twig_environment) {
    $this->twigEnvironment = $twig_environment;
    parent::__construct($root, $cache, $twig_extension_hash, $state, $loader = NULL, $options = []);
  }

  /**
   * Invalidates all compiled Twig templates.
   *
   * @see \drupal_flush_all_caches
   */
  public function invalidate() {
    // PhpStorageFactory::get('twig')->deleteAll();
    // $this->twigEnvironment->templateClasses = [];
    // $this->twigEnvironment->loadedTemplates = [];
    // $this->twigEnvironment->state->delete(static::CACHE_PREFIX_METADATA_KEY);
    $message = 'Cache flush triggered';
    $backtrace = debug_backtrace();
    $trace = Error::formatBacktrace($backtrace);
    $variables = array(
      '%type' => 'flush_trace',
      '@message' => $message,
      '%backtrace_string' => $trace,
    );
    // if printing to screen
    $msg = t('%type: @message in %backtrace_string', $variables);
    drupal_set_message($msg, 'warning', TRUE);
    // \Drupal::logger('flush_trace')->notice($msg);
  }
}
