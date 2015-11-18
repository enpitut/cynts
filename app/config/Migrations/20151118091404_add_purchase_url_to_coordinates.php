<?php
use Migrations\AbstractMigration;

class AddPurchaseUrlToCoordinates extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('coordinates');
        $table->addColumn('purchase_url', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->update();
    }
}
