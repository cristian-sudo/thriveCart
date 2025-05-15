<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('initializes the basket with product catalog, delivery rules, and offers via API')->todo();

it('adds a product to the basket by product code via API')->todo();

it('calculates the total cost of the basket without any offers via API')->todo();

it('applies the "buy one red widget, get the second half price" offer via API')->todo();

it('calculates the total cost with delivery charges applied via API')->todo();

it('calculates the total cost with free delivery via API')->todo();
