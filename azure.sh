#composer global require sebastian/phpcpd
#composer global require phploc/phploc
#composer global require phpmd/phpmd
#composer global require squizlabs/php_codesniffer
#composer global require pdepend/pdepend
#composer global require phpstan/phpstan
#composer global require povils/phpmnd
#composer global require bmitch/churn-php
#composer require nunomaduro/phpinsights
#composer global require phpmetrics/phpmetrics

#composer install
#composer require phpunit/phpunit "6.5.14"
./vendor/bin/phpinsights
~/.composer/vendor/bin/pdepend --summary-xml=phpdepend_summary.xml src/
~/.composer/vendor/bin/phploc src/
~/.composer/vendor/bin/phpmetrics --report-html=myreport.html src/
vendor/bin/phpcs --extensions=php --standard=PSR1,PSR2 src/
~/.composer/vendor/bin/phpmd src/ text cleancode,codesize,design,unusedcode,naming,controversial
~/.composer/vendor/bin/phpstan analyse src/ --level=7
~/.composer/vendor/bin/churn run src/
~/.composer/vendor/bin/phpmnd src/
~/.composer/vendor/bin/phpcpd src/

