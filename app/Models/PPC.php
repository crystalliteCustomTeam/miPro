<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PPC extends Model
{
    use HasFactory;
    protected $table = 'ppc';
    protected $fillable = [
        "Campaign_status",
        "Campaign",
        "Budget",
        "Budget_type",
        "Optimization_score",
        "Account",
        "Campaign_type",
        "Interactions",
        "Cost",
        "Impr",
        "Bid_strategy_type",
        "CampaignID",
        "Clicks",
        "New_Account",
        "startdate",
        "enddate"

    ];
}
