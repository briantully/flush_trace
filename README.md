# flush_trace
experimental module to add backtrace debug to cache_clear and Twig invalidate

## Installation

- Download into your custom modules directory and enable the module "Flush trace (flush_trace)"
- `drush en flush_trace`

## What it does

- Whenever cache is cleared, `hook_cache_flush()` is called. This module adds a log message "Cache flush triggered" along with a backtrace of which item invoked the cache flush.
- Whenever `\Drupal::service('twig')->invalidate()` is called, we decorate the TwigEnvironment service and add a log message "Twig invalidate triggered" along with a backtrace of which item invoked the invalidation.

## Caveats

- To avoid out of memory (OOM) errors from a deep backtrace, we limit the depth of the backtrace to 10 by default. The backtrace depth is configurable at `/admin/config/development/logging/flush_trace`, where you can increase backtrace depth up to a max of `50`.
