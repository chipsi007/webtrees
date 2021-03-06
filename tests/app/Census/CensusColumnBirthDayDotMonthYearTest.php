<?php
/**
 * webtrees: online genealogy
 * Copyright (C) 2019 webtrees development team
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */
declare(strict_types=1);

namespace Fisharebest\Webtrees\Census;

use Fisharebest\Webtrees\Date;
use Fisharebest\Webtrees\Date\GregorianDate;
use Fisharebest\Webtrees\Individual;
use Mockery;

/**
 * Test harness for the class CensusColumnBirthDayDotMonthYearTest
 */
class CensusColumnBirthDayDotMonthYearTest extends \Fisharebest\Webtrees\TestCase
{
    /**
     * Delete mock objects
     *
     * @return void
     */
    public function tearDown()
    {
        Mockery::close();
    }

    /**
     * @covers \Fisharebest\Webtrees\Census\CensusColumnBirthDayDotMonthYearTest
     * @covers \Fisharebest\Webtrees\Census\AbstractCensusColumn
     *
     * @return void
     */
    public function testGenerateColumn()
    {
        $cal_date = Mockery::mock(GregorianDate::class);
        $cal_date->shouldReceive('format')->andReturn('30. June 1832');

        $date = Mockery::mock(Date::class);
        $date->shouldReceive('minimumJulianDay')->andReturn(2390364);
        $date->shouldReceive('maximumJulianDay')->andReturn(2390364);
        $date->shouldReceive('minimumDate')->andReturn($cal_date);

        $individual = Mockery::mock(Individual::class);
        $individual->shouldReceive('getBirthDate')->andReturn($date);

        $census = Mockery::mock(CensusInterface::class);
        $census->shouldReceive('censusDate')->andReturn('30 JUN 1832');

        $column = new CensusColumnBirthDayDotMonthYear($census, '', '');

        $this->assertSame('30. June 1832', $column->generate($individual, $individual));
    }
}
