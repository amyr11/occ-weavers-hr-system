<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class EmployeeLeavesCluster extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-m-calendar-days';

    protected static ?int $navigationSort = 3;
}
