<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201006053113 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, gallery_id INT DEFAULT NULL, title VARCHAR(100) NOT NULL, meta_title VARCHAR(100) NOT NULL, description VARCHAR(255) NOT NULL, image_name VARCHAR(255) NOT NULL, image_size INT NOT NULL, updated_at DATETIME NOT NULL, slug VARCHAR(255) NOT NULL, created DATETIME DEFAULT NULL, updated DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_C53D045F989D9B62 (slug), INDEX IDX_C53D045F4E7AF8F (gallery_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image_gallery (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, title VARCHAR(100) NOT NULL, meta_title VARCHAR(100) NOT NULL, description VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, created DATETIME DEFAULT NULL, updated DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_D23B2FE6989D9B62 (slug), INDEX IDX_D23B2FE6727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_file (id INT AUTO_INCREMENT NOT NULL, post_id INT DEFAULT NULL, title VARCHAR(100) NOT NULL, meta_title VARCHAR(100) NOT NULL, description VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_size INT NOT NULL, updated_at DATETIME NOT NULL, slug VARCHAR(255) NOT NULL, created DATETIME DEFAULT NULL, updated DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_45CA511B989D9B62 (slug), INDEX IDX_45CA511B4B89032C (post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F4E7AF8F FOREIGN KEY (gallery_id) REFERENCES image_gallery (id)');
        $this->addSql('ALTER TABLE image_gallery ADD CONSTRAINT FK_D23B2FE6727ACA70 FOREIGN KEY (parent_id) REFERENCES image_gallery (id)');
        $this->addSql('ALTER TABLE post_file ADD CONSTRAINT FK_45CA511B4B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE post ADD image_gallery_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D6839B8B9 FOREIGN KEY (image_gallery_id) REFERENCES image_gallery (id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D6839B8B9 ON post (image_gallery_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F4E7AF8F');
        $this->addSql('ALTER TABLE image_gallery DROP FOREIGN KEY FK_D23B2FE6727ACA70');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D6839B8B9');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE image_gallery');
        $this->addSql('DROP TABLE post_file');
        $this->addSql('DROP INDEX IDX_5A8A6C8D6839B8B9 ON post');
        $this->addSql('ALTER TABLE post DROP image_gallery_id');
    }
}
