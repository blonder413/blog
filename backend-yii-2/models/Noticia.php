<?php

namespace app\models;

use yii\behaviors\SluggableBehavior;
use yii\db\Expression;
use yii\helpers\BaseUrl;

use Yii;

/**
 * This is the model class for table "articulo".
 *
 * @property int $id
 * @property string $titulo
 * @property string $slug
 * @property string $detalle
 * @property int $categoria_id
 * @property int $estado
 * @property int $created_by
 * @property string $created_at
 * @property int $updated_by
 * @property string $updated_at
 *
 * @property Categoria $categoria
 * @property User $createdBy
 * @property User $updatedBy
 * @property Comentario[] $comentarios
 */
class Noticia extends \yii\db\ActiveRecord
{
    const ESTADO_INACTIVO = 0;
    const ESTADO_ACTIVO = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'noticias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['categoria_id', 'estado', 'created_by', 'updated_by'], 'integer'],
            [['titulo', 'detalle', 'categoria_id'], 'required'],
            [['detalle'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['titulo', 'slug'], 'string', 'max' => 150],
            [['titulo'], 'unique'],
            [['slug'], 'unique'],
            [['estado'], 'default', 'value' => self::ESTADO_ACTIVO],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::class, 'targetAttribute' => ['categoria_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                => 'ID',
            'titulo'            => 'Título',
            'slug'              => 'Slug',
            'detalle'           => 'Detalle',
            'categoria_id'      => 'Categoría',
            'estado'            => 'Estado',
            'usuario_crea'      => 'Usuario Crea',
            'created_at'        => 'Fecha Crea',
            'usuario_modifica'  => 'Usuario Modifica',
            'updated_at'    => 'Fecha Modifica',
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'titulo',
                //'slugAttribute' => 'seo_slug',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->estado           = self::ESTADO_ACTIVO;
                $this->created_by     = Yii::$app->user->id;
                $this->created_at       = new Expression('NOW()');
                $this->updated_by = Yii::$app->user->id;
                $this->updated_at   = new Expression('NOW()');
            } else {
                if (isset(Yii::$app->user->id)) {
                    $this->updated_by = Yii::$app->user->id;
                    $this->updated_at   = new Expression('NOW()');
                }
            }
            return true;
        }
        return false;
    }

    /**
     * Gets query for [[Categoria]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categoria::class, ['id' => 'categoria_id']);
    }

    /**
     * Gets query for [[UsuarioCrea]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioCrea()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * Gets query for [[UsuarioModifica]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioModifica()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }
}
