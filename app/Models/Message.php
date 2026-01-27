<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être remplis en masse.
     * * ressource_id : lie le message au matériel concerné
     * user_id      : identifie l'auteur du message
     * content      : le texte du message ou de l'alerte
     */
    protected $fillable = [
        'ressource_id',
        'user_id',
        'content',
    ];

    /**
     * Relation : Un message appartient à une seule ressource.
     * Cela te permet de filtrer les messages par matériel.
     */
    public function ressource()
    {
        return $this->belongsTo(Ressource::class, 'ressource_id');
    }

    /**
     * Relation : Un message est écrit par un utilisateur.
     * Utile pour afficher le nom de celui qui a posté l'alerte.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}