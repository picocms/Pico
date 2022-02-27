# Pico -- Makefile
# Makefile to build new Pico releases using './.build/build.sh'.
#
# This file is part of Pico, a stupidly simple, blazing fast, flat file CMS.
# Visit us at https://picocms.org/ for more info.
#
# Copyright (c) 2022  Daniel Rudolf <https://www.daniel-rudolf.de>
#
# This work is licensed under the terms of the MIT license.
# For a copy, see LICENSE file or <https://opensource.org/licenses/MIT>.
#
# SPDX-License-Identifier: MIT
# License-Filename: LICENSE

version?=
nocheck?=false

php?=php
composer?=composer

app_name=pico
archive_tar=$(app_name)-release-*.tar.gz
archive_zip=$(app_name)-release-*.zip
export=$(app_name)-export.tar.gz

all: clean build

clean: clean-build clean-export

clean-build:
	find "." -name "$(archive_tar)" -exec rm -f {} \;
	find "." -name "$(archive_zip)" -exec rm -f {} \;

clean-export:
	rm -f "./$(export)"

build: export PHP=$(php)
build: export COMPOSER=$(composer)
build:
	./.build/build.sh$(if $(filter true,$(nocheck)), --no-check,)$(if $(version), "$(version)",)

export:
	git archive --prefix "$(app_name)/" -o "./$(export)" HEAD

composer:
	$(composer) install --optimize-autoloader --no-dev

.PHONY: all \
	clean clean-build clean-export \
	build export \
	composer
