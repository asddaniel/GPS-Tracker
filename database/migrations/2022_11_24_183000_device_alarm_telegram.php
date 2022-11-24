<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\Shared\Migration\MigrationAbstract;

return new class extends MigrationAbstract
{
    /**
     * @return void
     */
    public function up()
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->tables();
        $this->upFinish();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('device_alarm', 'telegram');
    }

    /**
     * @return void
     */
    protected function tables()
    {
        Schema::table('device_alarm', function (Blueprint $table) {
            $table->boolean('telegram')->default(0);
        });

        Schema::table('device_alarm_notification', function (Blueprint $table) {
            $table->boolean('telegram')->default(0);
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('device_alarm', function (Blueprint $table) {
            $table->dropColumn('telegram');
        });

        Schema::table('device_alarm_notification', function (Blueprint $table) {
            $table->dropColumn('telegram');
        });
    }
};
