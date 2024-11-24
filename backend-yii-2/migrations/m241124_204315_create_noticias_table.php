<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%noticias}}`.
 */
class m241124_204315_create_noticias_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%noticias}}', [
            'id' => $this->primaryKey(),
            'titulo' => $this->string(200),
            'slug' => $this->string(200),
            'detalle'   => $this->text(),
            'categoria_id' => $this->integer(),
            'estado'    => $this->boolean(),
            'created_by' => $this->integer(),
            'created_at' => $this->dateTime(),
            'updated_by' => $this->integer(),
            'updated_at' => $this->dateTime(),
        ]);
        $this->addForeignKey(
            'categoria_noticia',
            'noticias',
            'categoria_id',
            'categorias',
            'id',
            'no action',
            'no action'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%noticias}}');
    }
}
