<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240724004835 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE appointments (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', speciality_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', time_start TIME NOT NULL COMMENT \'(DC2Type:time_immutable)\', time_end TIME NOT NULL COMMENT \'(DC2Type:time_immutable)\', date_appointment DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_6A41727A3B5A08D7 (speciality_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE doctor_data (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', users_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', professional_card VARCHAR(50) NOT NULL, professional_phone VARCHAR(50) NOT NULL, gender VARCHAR(50) NOT NULL, active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_EB72CD0367B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE eps (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(200) NOT NULL, description LONGTEXT NOT NULL, active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE eps_users (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', eps_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', users_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_AE5463B5F0A3CCD5 (eps_id), INDEX IDX_AE5463B567B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient_data (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', users_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', address VARCHAR(255) NOT NULL, phone VARCHAR(30) NOT NULL, gender VARCHAR(50) NOT NULL, personal_identification VARCHAR(50) NOT NULL, active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_2462BEAB67B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE specialities (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(200) NOT NULL, last_name VARCHAR(200) NOT NULL, active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_appointments (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', doctor_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', patient_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', appointment_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', is_attended TINYINT(1) NOT NULL, active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_3905547687F4FB17 (doctor_id), INDEX IDX_390554766B899279 (patient_id), INDEX IDX_39055476E5B533F9 (appointment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE appointments ADD CONSTRAINT FK_6A41727A3B5A08D7 FOREIGN KEY (speciality_id) REFERENCES specialities (id)');
        $this->addSql('ALTER TABLE doctor_data ADD CONSTRAINT FK_EB72CD0367B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE eps_users ADD CONSTRAINT FK_AE5463B5F0A3CCD5 FOREIGN KEY (eps_id) REFERENCES eps (id)');
        $this->addSql('ALTER TABLE eps_users ADD CONSTRAINT FK_AE5463B567B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE patient_data ADD CONSTRAINT FK_2462BEAB67B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE users_appointments ADD CONSTRAINT FK_3905547687F4FB17 FOREIGN KEY (doctor_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE users_appointments ADD CONSTRAINT FK_390554766B899279 FOREIGN KEY (patient_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE users_appointments ADD CONSTRAINT FK_39055476E5B533F9 FOREIGN KEY (appointment_id) REFERENCES appointments (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appointments DROP FOREIGN KEY FK_6A41727A3B5A08D7');
        $this->addSql('ALTER TABLE doctor_data DROP FOREIGN KEY FK_EB72CD0367B3B43D');
        $this->addSql('ALTER TABLE eps_users DROP FOREIGN KEY FK_AE5463B5F0A3CCD5');
        $this->addSql('ALTER TABLE eps_users DROP FOREIGN KEY FK_AE5463B567B3B43D');
        $this->addSql('ALTER TABLE patient_data DROP FOREIGN KEY FK_2462BEAB67B3B43D');
        $this->addSql('ALTER TABLE users_appointments DROP FOREIGN KEY FK_3905547687F4FB17');
        $this->addSql('ALTER TABLE users_appointments DROP FOREIGN KEY FK_390554766B899279');
        $this->addSql('ALTER TABLE users_appointments DROP FOREIGN KEY FK_39055476E5B533F9');
        $this->addSql('DROP TABLE appointments');
        $this->addSql('DROP TABLE doctor_data');
        $this->addSql('DROP TABLE eps');
        $this->addSql('DROP TABLE eps_users');
        $this->addSql('DROP TABLE patient_data');
        $this->addSql('DROP TABLE specialities');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE users_appointments');
    }
}
