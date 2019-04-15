# flush_trace
experimental module to add backtrace debug to cache_clear and Twig invalidate

## Installation

- Download into your custom modules directory and enable the module "Flush trace (flush_trace)"
- `drush en flush_trace`

## What it does

- Whenever cache is cleared, hook_cache_flush is called. This module adds a log message "Cache flush triggered" along with a backtrace of which item invoked the cache flush.
- Whenever TwigEnvironment->invalidate is called, we decorate the TwigEnvironment service and add a log message "Twig invalidate triggered" along with a backtrace of which item invoked the invalidate.

## Caveats

- To avoid out of memory (OOM) errors from deep backtrace, we limit the depth of the backtrace to 10.
