# Makefile

# Run Pest tests
test:
	@./vendor/bin/pest

# Run PHPStan analysis
phpstan:
	@./vendor/bin/phpstan analyse app

# Run both tests and PHPStan
check: test phpstan
