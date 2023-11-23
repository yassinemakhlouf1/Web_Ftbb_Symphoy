<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210416143401 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article CHANGE article_id article_id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE cart CHANGE addition_id addition_id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE classement DROP FOREIGN KEY c2');
        $this->addSql('ALTER TABLE classement DROP FOREIGN KEY ph1');
        $this->addSql('ALTER TABLE classement DROP FOREIGN KEY t2');
        $this->addSql('ALTER TABLE classement CHANGE id_phase id_phase INT DEFAULT NULL, CHANGE id_competition id_competition INT DEFAULT NULL, CHANGE id_team id_team INT DEFAULT NULL');
        $this->addSql('ALTER TABLE classement ADD CONSTRAINT FK_55EE9D6DAD18E146 FOREIGN KEY (id_competition) REFERENCES competition (id)');
        $this->addSql('ALTER TABLE classement ADD CONSTRAINT FK_55EE9D6D5F3897FB FOREIGN KEY (id_phase) REFERENCES phase (id)');
        $this->addSql('ALTER TABLE classement ADD CONSTRAINT FK_55EE9D6D4FC0BA1D FOREIGN KEY (id_team) REFERENCES team (id)');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY client_ibfk_1');
        $this->addSql('ALTER TABLE client CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE password_id password_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C74404553E4A79C1 FOREIGN KEY (password_id) REFERENCES password (password_id)');
        $this->addSql('ALTER TABLE command CHANGE command_id command_id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE command_product CHANGE id_cp id_cp INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY comment_ibfk_1');
        $this->addSql('ALTER TABLE comment CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE article_id article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C7294869C FOREIGN KEY (article_id) REFERENCES article (article_id)');
        $this->addSql('ALTER TABLE feedback CHANGE feedback_id feedback_id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE galerie CHANGE galerie_id galerie_id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY t3');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY t4');
        $this->addSql('ALTER TABLE game CHANGE id_competition id_competition INT DEFAULT NULL, CHANGE id_phase id_phase INT DEFAULT NULL, CHANGE id_week id_week INT DEFAULT NULL, CHANGE id_team_home id_team_home INT DEFAULT NULL, CHANGE id_team_away id_team_away INT DEFAULT NULL');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CF78BEA8D FOREIGN KEY (id_team_away) REFERENCES team (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C2002448C FOREIGN KEY (id_team_home) REFERENCES team (id)');
        $this->addSql('ALTER TABLE likes CHANGE id_like id_like INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE options DROP FOREIGN KEY options_ibfk_1');
        $this->addSql('ALTER TABLE options CHANGE option_id option_id INT AUTO_INCREMENT NOT NULL, CHANGE poll_id poll_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE options ADD CONSTRAINT FK_D035FA873C947C0F FOREIGN KEY (poll_id) REFERENCES poll (poll_id)');
        $this->addSql('ALTER TABLE password CHANGE password_id password_id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY t1');
        $this->addSql('ALTER TABLE player CHANGE id_team id_team INT DEFAULT NULL');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A654FC0BA1D FOREIGN KEY (id_team) REFERENCES team (id)');
        $this->addSql('ALTER TABLE poll CHANGE poll_id poll_id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE product CHANGE ref_product ref_product INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE report CHANGE report_id report_id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY c1');
        $this->addSql('ALTER TABLE team CHANGE id_competition id_competition INT DEFAULT NULL');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61FAD18E146 FOREIGN KEY (id_competition) REFERENCES competition (id)');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY vote_ibfk_1');
        $this->addSql('ALTER TABLE vote CHANGE vote_id vote_id INT AUTO_INCREMENT NOT NULL, CHANGE option_id option_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564A7C41D6F FOREIGN KEY (option_id) REFERENCES options (option_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article CHANGE article_id article_id INT NOT NULL');
        $this->addSql('ALTER TABLE cart CHANGE addition_id addition_id INT NOT NULL');
        $this->addSql('ALTER TABLE classement DROP FOREIGN KEY FK_55EE9D6DAD18E146');
        $this->addSql('ALTER TABLE classement DROP FOREIGN KEY FK_55EE9D6D5F3897FB');
        $this->addSql('ALTER TABLE classement DROP FOREIGN KEY FK_55EE9D6D4FC0BA1D');
        $this->addSql('ALTER TABLE classement CHANGE id_competition id_competition INT NOT NULL, CHANGE id_phase id_phase INT NOT NULL, CHANGE id_team id_team INT NOT NULL');
        $this->addSql('ALTER TABLE classement ADD CONSTRAINT c2 FOREIGN KEY (id_competition) REFERENCES competition (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE classement ADD CONSTRAINT ph1 FOREIGN KEY (id_phase) REFERENCES phase (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE classement ADD CONSTRAINT t2 FOREIGN KEY (id_team) REFERENCES team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C74404553E4A79C1');
        $this->addSql('ALTER TABLE client CHANGE id id INT NOT NULL, CHANGE password_id password_id INT NOT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT client_ibfk_1 FOREIGN KEY (password_id) REFERENCES password (password_id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE command CHANGE command_id command_id INT NOT NULL');
        $this->addSql('ALTER TABLE command_product CHANGE id_cp id_cp INT NOT NULL');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C7294869C');
        $this->addSql('ALTER TABLE comment CHANGE id id INT NOT NULL, CHANGE article_id article_id INT NOT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT comment_ibfk_1 FOREIGN KEY (article_id) REFERENCES article (article_id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE feedback CHANGE feedback_id feedback_id INT NOT NULL');
        $this->addSql('ALTER TABLE galerie CHANGE galerie_id galerie_id INT NOT NULL');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CF78BEA8D');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C2002448C');
        $this->addSql('ALTER TABLE game CHANGE id_competition id_competition INT NOT NULL, CHANGE id_phase id_phase INT NOT NULL, CHANGE id_team_away id_team_away INT NOT NULL, CHANGE id_team_home id_team_home INT NOT NULL, CHANGE id_week id_week INT NOT NULL');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT t3 FOREIGN KEY (id_team_away) REFERENCES team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT t4 FOREIGN KEY (id_team_home) REFERENCES team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE likes CHANGE id_like id_like INT NOT NULL');
        $this->addSql('ALTER TABLE options DROP FOREIGN KEY FK_D035FA873C947C0F');
        $this->addSql('ALTER TABLE options CHANGE option_id option_id INT NOT NULL, CHANGE poll_id poll_id INT NOT NULL');
        $this->addSql('ALTER TABLE options ADD CONSTRAINT options_ibfk_1 FOREIGN KEY (poll_id) REFERENCES poll (poll_id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE password CHANGE password_id password_id INT NOT NULL');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A654FC0BA1D');
        $this->addSql('ALTER TABLE player CHANGE id_team id_team INT NOT NULL');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT t1 FOREIGN KEY (id_team) REFERENCES team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE poll CHANGE poll_id poll_id INT NOT NULL');
        $this->addSql('ALTER TABLE product CHANGE ref_product ref_product INT NOT NULL');
        $this->addSql('ALTER TABLE report CHANGE report_id report_id INT NOT NULL');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61FAD18E146');
        $this->addSql('ALTER TABLE team CHANGE id_competition id_competition INT NOT NULL');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT c1 FOREIGN KEY (id_competition) REFERENCES competition (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A108564A7C41D6F');
        $this->addSql('ALTER TABLE vote CHANGE vote_id vote_id INT NOT NULL, CHANGE option_id option_id INT NOT NULL');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT vote_ibfk_1 FOREIGN KEY (option_id) REFERENCES options (option_id) ON UPDATE CASCADE ON DELETE CASCADE');
    }
}
