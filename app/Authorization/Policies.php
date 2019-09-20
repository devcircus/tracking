<?php

namespace App\Authorization;

class Policies
{
    public const ADMINISTER_TAGS = 'administerTags';
    public const DELETE_TAGS = 'deleteTags';
    public const FINISH_TAGS = 'finishTags';
    public const RESTORE_TAGS = 'restoreTags';
    public const ACTIVATE_TAGS = 'activateTags';

    public const ADMINISTER_ITEMS = 'administerItems';
    public const DELETE_ITEMS = 'deleteItems';
    public const FINISH_ITEMS = 'finishItems';
    public const RESTORE_ITEMS = 'restoreItems';
    public const CREATE_ITEMS = 'createItems';

    public const ADMINISTER_FABRICS = 'administerFabrics';
    public const DELETE_FABRICS = 'deleteFabrics';
    public const FINISH_FABRICS = 'finishFabrics';
    public const RESTORE_FABRICS = 'restoreFabrics';
    public const CREATE_FABRICS = 'createFabrics';

    public const ADMINISTER_COLORS = 'administerColors';
    public const DELETE_COLORS = 'deleteColors';
    public const FINISH_COLORS = 'finishColors';
    public const RESTORE_COLORS = 'restoreColors';
    public const CREATE_COLORS = 'createColors';

    public const ADMINISTER_INKS = 'administerInks';
    public const DELETE_INKS = 'deleteInks';
    public const FINISH_INKS = 'finishInks';
    public const RESTORE_INKS = 'restoreInks';
    public const CREATE_INKS = 'createInks';

    public const ADMINISTER_PRINTERS = 'administerPrinters';
    public const DELETE_PRINTERS = 'deletePrinters';
    public const FINISH_PRINTERS = 'finishPrinters';
    public const RESTORE_PRINTERS = 'restorePrinters';
    public const CREATE_PRINTERS = 'createPrinters';

    public const ADMINISTER_REPORTS = 'administerReports';

    public const ADMINISTER_ACTIVITIES = 'administerActivities';

    /** @var array */
    protected $policies = [];

    /**
     * Set the application policies.
     *
     * @param  array  $policies
     */
    public function setPolicies($policies): void
    {
        $this->policies = $policies;
    }

    /**
     * Get the application policies.
     */
    public function getPolicies(): array
    {
        return $this->policies;
    }
}
