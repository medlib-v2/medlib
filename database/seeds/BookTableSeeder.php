<?php

use \Medlib\Models\Book;
use Illuminate\Database\Seeder;

class BookTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Book::insert([
            'isbn' => '978-2-8159-0345-5',
            'title' => 'La part du colibri. L\'espèce humaine face à son devenir',
            'issn' => '9782815903455',
            'pages' => 64,
            'language' => 'Français',
            'edition_id' => 4,
            'publication' => '2011-07-29',
            'notes' => 'Ce texte de Pierre Rabhi nous amène à ouvrir les yeux sur le devenir de la planète et de l\'espèce humaine, et propose une réflexion sur la nécessaire décroissance. Il apporte des solutions concrètes, réalistes, que chacun peut mettre en œuvre.

Pierre Rabhi appelle à « l’insurrection des consciences » pour fédérer ce que l’humanité a de meilleur et cesser de faire de notre planète-paradis un enfer de souffrances et de destructions. Initiateur de nombreuses actions au Nord comme au Sud vouées à l’écologie et à l’humanisme, il participe à l’indispensable conciliation de l’histoire humaine avec la réalité naturelle, seule garante de la survie de tous. Selon lui, la crise qui affecte la planète n’est pas structurelle, économique, écologique ou politique, mais avant tout profondément humaine. Il pense que notre modèle d’existence est erroné et qu’un nouveau paradigme replaçant l’humain et la nature au cœur de nos préoccupations - et l’économie, la technologie, la science à leur service - est indispensable et urgent. Après avoir mis sa propre vie en conformité avec ses convictions, il personnifie à travers ce texte l’homme public qu’il est devenu chemin faisant, en sensibilisant, en témoignant, mais aussi en incarnant les alternatives qu’il propose.',
            'author_id' => 1,
            'publisher_id' => 7,
            'category_id' => 1

        ]);

        Book::insert([
            'isbn' => '2253109584',
            'title' => 'Lorsque j\'étais une œuvre d\'art',
            'issn' => '9782253109587',
            'pages' => 252,
            'language' => 'Français',
            'edition_id' => 2,
            'publication' => '2004-09-01',
            'notes' => 'Lorsque j\'étais une œuvre d\'art est un livre sans équivalent dans l\'histoire de la littérature, même si c\'est un roman contemporain sur le contemporain. Il raconte le calvaire d\'un homme qui devient son propre corps, un corps refaçonné en œuvre d\'art au mépris de tout respect pour son humanité. Malléable, transformable, il n\'est plus qu\'un corps sans âme entre les mains d\'un esprit diabolique dont le génie tient avant tout à son manque de scrupule.',
            'author_id' => 4,
            'publisher_id' => 2,
            'category_id' => 6

        ]);

        Book::insert([
            'isbn' => '0747560722',
            'title' => 'Harry Potter et la chambre des secrets',
            'issn' => '9780747560722',
            'pages' => 364,
            'language' => 'Français',
            'edition_id' => 3,
            'publication' => '2011-07-29',
            'notes' => 'Harry Potter fait une rentrée fracassante en voiture volante à l\'école des sorciers. Cette deuxième année ne s\'annonce pas de tout repos... surtout depuis qu\'une étrange malédiction s\'est abattue sur les élèves. Entre les cours de potion magique, les matches de Quidditch et les combats de mauvais sorts, Harry et ses amis Ron et Hermione trouveront-ils le temps de percer le mystère de la Chambre des Secrets ?Un livre magique pour sorciers confirmés.',
            'author_id' => 2,
            'publisher_id' => 8,
            'category_id' => 3
        ]);

        Book::insert([
            'isbn' => '2203077102',
            'title' => 'La bible selon le chat',
            'issn' => '9782203077102',
            'pages' => 64,
            'language' => 'Français',
            'edition_id' => 5,
            'publication' => '2013-10-13',
            'notes' => 'La Bible selon Le Chat répond à toutes les questions que se posent les humains depuis la nuit des temps. Fini le doute, voici la lumière. Avec cet album, la communauté des hommes va enfin comprendre pourquoi il était vain de s’entre-massacrer depuis tant d’années.
La vérité sur tout cela, Le Chat nous la révèle dans son onzième commandement (le moins connu, sans doute le plus beau) : « Tu riras de tout, car, vu qu’on va tous crever un jour, seul l’humour te permettra d’avoir un peu de recul sur les vicissitudes de l’existence ».',
            'author_id' => 5,
            'publisher_id' => 3,
            'category_id' => 7

        ]);

        Book::insert([
            'isbn' => '978-2253142935',
            'title' => 'Maigret, l\'affaire Saint-Fiacre',
            'issn' => '9782815903455',
            'pages' => 186,
            'language' => 'Français',
            'edition_id' => 2,
            'publication' => '1932-01-01',
            'notes' => 'Dans l\'église du village de Saint-Fiacre (village fictif inspiré de Paray-le-Frésil), la comtesse, femme au cœur fragile, succombe à une crise cardiaque. Il s\'agit bien pourtant d\'un crime commis à l\'aide d\'une simple coupure de journal glissée dans le missel de la comtesse de Saint-Fiacre : une lettre anonyme a prévenu les services de police judiciaire. Maigret assiste impuissant au forfait. Il rencontre ensuite les suspects, mais évoque surtout les souvenirs qui affluent de son enfance passée en ces lieux.

Le coupable est démasqué lors d\'un dîner placé sous le signe de Walter Scott où tous les protagonistes seront rassemblés, et c\'est le comte de Saint-Fiacre qui va résoudre l\'énigme. La preuve est toutefois apportée par Maigret qui se fait la réflexion que « son rôle dans cette affaire s\'était borné à apporter le dernier chaînon, un tout petit chaînon qui bouclait parfaitement le cercle. ».',
            'author_id' => 3,
            'publisher_id' => 2,
            'category_id' => 4

        ]);
    }
}