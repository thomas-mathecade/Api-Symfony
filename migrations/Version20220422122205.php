<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220422122205 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE inscription (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscription_personne (inscription_id INT NOT NULL, personne_id INT NOT NULL, INDEX IDX_A65BB64A5DAC5993 (inscription_id), INDEX IDX_A65BB64AA21BD112 (personne_id), PRIMARY KEY(inscription_id, personne_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscription_trajet (inscription_id INT NOT NULL, trajet_id INT NOT NULL, INDEX IDX_2364DDF55DAC5993 (inscription_id), INDEX IDX_2364DDF5D12A823 (trajet_id), PRIMARY KEY(inscription_id, trajet_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marque (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personne (id INT AUTO_INCREMENT NOT NULL, ville_id INT DEFAULT NULL, voiture_id INT DEFAULT NULL, user_id INT DEFAULT NULL, nom VARCHAR(30) NOT NULL, prenom VARCHAR(30) NOT NULL, date_naiss DATETIME NOT NULL, tel VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, INDEX IDX_FCEC9EFA73F0036 (ville_id), INDEX IDX_FCEC9EF181A8BA (voiture_id), UNIQUE INDEX UNIQ_FCEC9EFA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personne_trajet (personne_id INT NOT NULL, trajet_id INT NOT NULL, INDEX IDX_1F219161A21BD112 (personne_id), INDEX IDX_1F219161D12A823 (trajet_id), PRIMARY KEY(personne_id, trajet_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trajet (id INT AUTO_INCREMENT NOT NULL, ville_dep_id INT DEFAULT NULL, ville_arr_id INT DEFAULT NULL, nbkms INT DEFAULT NULL, datetrajet DATETIME NOT NULL, INDEX IDX_2B5BA98C97A9E2C6 (ville_dep_id), INDEX IDX_2B5BA98CBFADF06C (ville_arr_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trajet_personne (trajet_id INT NOT NULL, personne_id INT NOT NULL, INDEX IDX_58D4CBCBD12A823 (trajet_id), INDEX IDX_58D4CBCBA21BD112 (personne_id), PRIMARY KEY(trajet_id, personne_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trajet_inscription (trajet_id INT NOT NULL, inscription_id INT NOT NULL, INDEX IDX_AE808345D12A823 (trajet_id), INDEX IDX_AE8083455DAC5993 (inscription_id), PRIMARY KEY(trajet_id, inscription_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, api_token VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D6497BA2F5EB (api_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ville (id INT AUTO_INCREMENT NOT NULL, ville VARCHAR(255) NOT NULL, codepostal INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE voiture (id INT AUTO_INCREMENT NOT NULL, marque_id INT DEFAULT NULL, nb_place INT NOT NULL, modele VARCHAR(255) NOT NULL, INDEX IDX_E9E2810F4827B9B2 (marque_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inscription_personne ADD CONSTRAINT FK_A65BB64A5DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inscription_personne ADD CONSTRAINT FK_A65BB64AA21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inscription_trajet ADD CONSTRAINT FK_2364DDF55DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inscription_trajet ADD CONSTRAINT FK_2364DDF5D12A823 FOREIGN KEY (trajet_id) REFERENCES trajet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE personne ADD CONSTRAINT FK_FCEC9EFA73F0036 FOREIGN KEY (ville_id) REFERENCES ville (id)');
        $this->addSql('ALTER TABLE personne ADD CONSTRAINT FK_FCEC9EF181A8BA FOREIGN KEY (voiture_id) REFERENCES voiture (id)');
        $this->addSql('ALTER TABLE personne ADD CONSTRAINT FK_FCEC9EFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE personne_trajet ADD CONSTRAINT FK_1F219161A21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE personne_trajet ADD CONSTRAINT FK_1F219161D12A823 FOREIGN KEY (trajet_id) REFERENCES trajet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trajet ADD CONSTRAINT FK_2B5BA98C97A9E2C6 FOREIGN KEY (ville_dep_id) REFERENCES ville (id)');
        $this->addSql('ALTER TABLE trajet ADD CONSTRAINT FK_2B5BA98CBFADF06C FOREIGN KEY (ville_arr_id) REFERENCES ville (id)');
        $this->addSql('ALTER TABLE trajet_personne ADD CONSTRAINT FK_58D4CBCBD12A823 FOREIGN KEY (trajet_id) REFERENCES trajet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trajet_personne ADD CONSTRAINT FK_58D4CBCBA21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trajet_inscription ADD CONSTRAINT FK_AE808345D12A823 FOREIGN KEY (trajet_id) REFERENCES trajet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trajet_inscription ADD CONSTRAINT FK_AE8083455DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE voiture ADD CONSTRAINT FK_E9E2810F4827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscription_personne DROP FOREIGN KEY FK_A65BB64A5DAC5993');
        $this->addSql('ALTER TABLE inscription_trajet DROP FOREIGN KEY FK_2364DDF55DAC5993');
        $this->addSql('ALTER TABLE trajet_inscription DROP FOREIGN KEY FK_AE8083455DAC5993');
        $this->addSql('ALTER TABLE voiture DROP FOREIGN KEY FK_E9E2810F4827B9B2');
        $this->addSql('ALTER TABLE inscription_personne DROP FOREIGN KEY FK_A65BB64AA21BD112');
        $this->addSql('ALTER TABLE personne_trajet DROP FOREIGN KEY FK_1F219161A21BD112');
        $this->addSql('ALTER TABLE trajet_personne DROP FOREIGN KEY FK_58D4CBCBA21BD112');
        $this->addSql('ALTER TABLE inscription_trajet DROP FOREIGN KEY FK_2364DDF5D12A823');
        $this->addSql('ALTER TABLE personne_trajet DROP FOREIGN KEY FK_1F219161D12A823');
        $this->addSql('ALTER TABLE trajet_personne DROP FOREIGN KEY FK_58D4CBCBD12A823');
        $this->addSql('ALTER TABLE trajet_inscription DROP FOREIGN KEY FK_AE808345D12A823');
        $this->addSql('ALTER TABLE personne DROP FOREIGN KEY FK_FCEC9EFA76ED395');
        $this->addSql('ALTER TABLE personne DROP FOREIGN KEY FK_FCEC9EFA73F0036');
        $this->addSql('ALTER TABLE trajet DROP FOREIGN KEY FK_2B5BA98C97A9E2C6');
        $this->addSql('ALTER TABLE trajet DROP FOREIGN KEY FK_2B5BA98CBFADF06C');
        $this->addSql('ALTER TABLE personne DROP FOREIGN KEY FK_FCEC9EF181A8BA');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('DROP TABLE inscription_personne');
        $this->addSql('DROP TABLE inscription_trajet');
        $this->addSql('DROP TABLE marque');
        $this->addSql('DROP TABLE personne');
        $this->addSql('DROP TABLE personne_trajet');
        $this->addSql('DROP TABLE trajet');
        $this->addSql('DROP TABLE trajet_personne');
        $this->addSql('DROP TABLE trajet_inscription');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE ville');
        $this->addSql('DROP TABLE voiture');
    }
}
