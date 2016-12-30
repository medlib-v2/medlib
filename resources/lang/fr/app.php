<?php

/*
 * This file is part of Medlib.
 *
 * Copyright (C) 2016 Medlib.fr
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [

    'name'              => "Nom de l'application",
    'about'             => "A propos de l'Application",
    'dashboard'         => 'Dashboard',
    'admin'             => 'Administration',
    'projects'          => 'Projets',
    'templates'         => 'Modèles',
    'groups'            => 'Groupes',
    'keys'              => 'Clé SSH',
    'users'             => 'Utilisateurs',
    'tips'              => 'Conseils',
    'links'             => 'Liens utiles',
    'notifications'     => 'Notifications',
    'created'           => 'Créé',
    'edit'              => 'Modifier',
    'confirm'           => 'Confirmer',
    'confirm_title'     => 'Confirmez votre action',
    'confirm_text'      => 'Es-tu sûr de vouloir faire ça?',
    'not_applicable'    => 'N/A',
    'date'              => 'Date',
    'status'            => 'Statut',
    'details'           => 'Détails',
    'delete'            => 'Supprimer',
    'save'              => 'Enregistrer',
    'close'             => 'Fermer',
    'never'             => 'Jamais',
    'none'              => 'Aucun',
    'yes'               => 'Oui',
    'no'                => 'Non',
    'warning'           => 'ATTENTION',
    'socket_error'      => 'Erreur du serveur',
    'socket_error_info' => "Aucune connexion n'a pas pu être établie à la prise au <strong>" . config('medlib.socket_url') . "</strong>.",
    'not_down'          => "Vous devez basculer en mode maintenance avant d'exécuter cette commande, ceci garantira qu'aucun nouveau déploiement ne sera lancé",
    'switch_down'       => "Passer en mode de maintenance maintenant? L'application revient au mode normal une fois le nettoyage terminé",
    'update_available'  => 'Une mise à jour est disponible!',
    'outdated'          => 'Vous exécutez une version :current, une version <a href=":link" rel="noreferrer">:latest</a> est disponible!',

];
