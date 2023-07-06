<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230706071216 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE answers ADD created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE answers ADD CONSTRAINT FK_50D0C6061E27F6BF FOREIGN KEY (question_id) REFERENCES questions (id)');
        $this->addSql('ALTER TABLE answers RENAME INDEX idx_dadd4a251e27f6bf TO IDX_50D0C6061E27F6BF');
        $this->addSql('ALTER TABLE categories ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE questions ADD created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D512469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE questions RENAME INDEX idx_b6f7494e12469de2 TO IDX_8ADC54D512469DE2');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE answers DROP FOREIGN KEY FK_50D0C6061E27F6BF');
        $this->addSql('ALTER TABLE answers DROP created_at');
        $this->addSql('ALTER TABLE answers RENAME INDEX idx_50d0c6061e27f6bf TO IDX_DADD4A251E27F6BF');
        $this->addSql('ALTER TABLE categories DROP created_at');
        $this->addSql('ALTER TABLE questions DROP FOREIGN KEY FK_8ADC54D512469DE2');
        $this->addSql('ALTER TABLE questions DROP created_at');
        $this->addSql('ALTER TABLE questions RENAME INDEX idx_8adc54d512469de2 TO IDX_B6F7494E12469DE2');
    }
}
