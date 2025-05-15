# KanbanBoard

## Übersicht
KanbanBoard ist eine Anwendung zur Verwaltung von Aufgaben nach dem Kanban-Prinzip. Die Anwendung ermöglicht es Benutzern, Aufgaben zu erstellen, zu organisieren und ihren Fortschritt zu verfolgen.

## Technologien
- **Backend**: Symfony 5.4 Framework mit Doctrine ORM
- **Frontend**: Vue.js 3 mit Vue Router und Vuex
- **Styling**: Bootstrap 5
- **Datenbank**: MariaDB (Entwicklung), SQLite (Tests)

## Installationsanleitung

### Voraussetzungen
- PHP 7.2.5 oder höher
- Erforderliche PHP-Erweiterungen: ctype, iconv
- Composer
- Node.js und npm
- Docker (optional, für Entwicklungsumgebung)

### Installation

1. **Repository klonen**:
   ```bash
   git clone <repository-url>
   cd KanbanBoard
   ```

2. **PHP-Abhängigkeiten installieren**:
   ```bash
   composer install
   ```

3. **JavaScript-Abhängigkeiten installieren**:
   ```bash
   npm install
   ```

4. **Frontend-Assets erstellen**:
   ```bash
   npm run build
   ```

5. **Entwicklungsserver starten**:
   ```bash
   symfony server:start
   ```

### Docker-Setup

Die Anwendung enthält eine Docker-Konfiguration für die Entwicklung:

1. **Docker-Container starten**:
   ```bash
   docker-compose up -d
   ```

2. **Datenbankkonfiguration**:
   - Die Datenbankanmeldedaten sind in der `compose.yaml` Datei konfiguriert
   - Die Verbindung zur Datenbank wird in `config/packages/doctrine.yaml` konfiguriert
   - Umgebungsvariablen für die Datenbankverbindung sind in `.env` oder in der Docker-Umgebung definiert

## Testen

### Testkonfiguration

1. **PHPUnit-Setup**:
   - Tests sind in `phpunit.xml.dist` konfiguriert
   - Tests verwenden standardmäßig eine SQLite-In-Memory-Datenbank
   - Das DAMA Doctrine Test Bundle wird verwendet, um Tests in Transaktionen zu verpacken

2. **Testumgebung**:
   - Die Testumgebung ist in `.env.test` konfiguriert
   - Erforderliche Umgebungsvariablen für Tests:
     ```
     DATABASE_URL="sqlite:///:memory:"
     MYSQL_DATABASE=test_db
     MYSQL_HOST=localhost
     MYSQL_USER=test_user
     MYSQL_PASSWORD=test_password
     MYSQL_PORT=3306
     ```

### Tests ausführen

1. **Alle Tests ausführen**:
   ```bash
   vendor/bin/phpunit
   ```

2. **Eine bestimmte Testdatei ausführen**:
   ```bash
   vendor/bin/phpunit tests/path/to/TestFile.php
   ```

3. **Tests mit Coverage-Bericht ausführen**:
   ```bash
   vendor/bin/phpunit --coverage-html coverage
   ```

## Entwicklungsinformationen

### Code-Stil und Qualität

1. **Statische Analyse**:
   - PHPStan ist auf Level 6 konfiguriert
   - Statische Analyse ausführen mit:
     ```bash
     vendor/bin/phpstan analyse
     ```

2. **Code-Stil**:
   - Das Projekt verwendet PHP-CS-Fixer für den Code-Stil
   - Befolgen Sie die PSR-12-Codierungsstandards

### Projektstruktur

1. **Backend**:
   - Symfony 5.4 Framework
   - Doctrine ORM für Datenbankzugriff
   - Entity-Klassen in `src/Entity`
   - Controller in `src/Controller`
   - Services in `src/Service`

2. **Frontend**:
   - Vue.js 3 mit Vue Router und Vuex
   - Komponenten in `assets/components`
   - Seiten in `assets/pages`
   - Layouts in `assets/layouts`
   - Webpack Encore für Asset-Management

### Sicherheit

1. **Authentifizierung**:
   - Die Anwendung verwendet Symfony Security für die Authentifizierung
   - Form-Login und API-Key-Authentifizierung werden unterstützt
   - Die User-Entity implementiert `UserInterface` und `PasswordAuthenticatedUserInterface`

### API-Entwicklung

1. **API-Struktur**:
   - Die Anwendung bietet eine REST-API
   - API-Endpunkte sind in Controllern definiert
   - Die `ApiHelper`-Klasse bietet Hilfsmittel zum Konvertieren von Entities in Arrays und JSON
   - Builder-Klassen sind für das Erstellen und Ändern von Entities verfügbar