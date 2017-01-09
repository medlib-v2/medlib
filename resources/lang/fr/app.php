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

    'name'              => "Medlib",
    'description'       => 'Recherche bibliographique',
    'about'             => "A propos de l'Application Medlib",
    'dashboard'         => 'Dashboard',
    'groups'            => 'Groupes',
    'users'             => 'Utilisateurs',
    'notifications'     => 'Notifications',
    'created'           => 'Créé',
    'edit'              => 'Modifier',
    'custom'            => 'Personnalisée',
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
    'explore_universe'  => '<h6>Explorez <strong>notre univers</strong></h6>',
    'universe'          => '<p class="paraf">L\'univers de <strong>Medlib</strong> donne accès à un ensemble des services spécifiquement adaptées et propose également une plate-fome d’échange.</p>',
    'discover_suggestions' => '<h6>Découvrez <strong>nos suggestions du jours</strong></h6>',
    'discover_suggestions_content' => '<p class="paraf">Rechercher tout type des documents avec <strong>Medlib</strong>, livre de science, romance etc...</p>',

];
