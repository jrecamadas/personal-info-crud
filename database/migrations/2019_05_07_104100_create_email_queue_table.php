<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailQueueTable extends Migration
{
    /**
     *
     * id - 			unsigned long(11)
     * status_id -     unsigned tynyint(5) 	(0 - pending, 1 - sent, 2 - error)
     * status_desc - 	varchar(191)		(status description)
     * sender_id - 	unsigned int(11)	(employee id, 0 for server initiated)
     * sender_name - 	varchar(50)		    (employee name, or 'Server')
     * sender_email - 	varchar(100)   		(employee email, or noreply@fullscale.rocks)
     * subject - 		varchar(100) 		(email subject)
     * send_to - 		text			    (emails of the recepients)
     * cc - 			text			    (emails of the cc'ed recepients) - nullable
     * bcc - 			text			    (emails of the bcc'ed recepients) - nullable
     * body - 			medium text		    (email body)
     * attachments - 	text			    (urls of the files, must have separator) - nullable
     * priority - 		unsigned tinyint(5)	(100 - most urgent, 1 - lowest prio) - default = 1
     * sent_at - 		timestamp		    (actual sent date & time using server time)
     * created_at - 	default
     * updated_at - 	default
     * deleted_at - 	default
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_queues', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->tinyInteger('status_id')->unsigned()->default(0);
            $table->string('status_desc');
            $table->integer('sender_id')->unsigned();
            $table->string('sender_name');
            $table->string('sender_email');
            $table->text('subject');
            $table->text('send_to');
            $table->text('cc')->nullable();
            $table->text('bcc')->nullable();
            $table->mediumText('body');
            $table->text('attachments')->nullable();
            $table->tinyInteger('priority')->default(1);
            $table->timestamp('sent_at')->comment('');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_queues');
    }
}
