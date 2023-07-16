<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230714120441 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE team_game DROP FOREIGN KEY FK_F2CAC5F7E48FD905');
        $this->addSql('ALTER TABLE team_game DROP FOREIGN KEY FK_F2CAC5F7296CD8AE');
        $this->addSql('DROP TABLE team_game');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE team_game (id INT AUTO_INCREMENT NOT NULL, team_id INT DEFAULT NULL, game_id INT DEFAULT NULL, number_of_points INT NOT NULL, INDEX IDX_F2CAC5F7E48FD905 (game_id), INDEX IDX_F2CAC5F7296CD8AE (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE team_game ADD CONSTRAINT FK_F2CAC5F7E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE team_game ADD CONSTRAINT FK_F2CAC5F7296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
    }
}
