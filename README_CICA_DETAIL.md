# Documentation détaillée du projet CICA

## Sommaire
- [1. Présentation générale](#1-pr%C3%A9sentation-g%C3%A9n%C3%A9rale)
- [2. Structure de la base de données](#2-structure-de-la-base-de-donn%C3%A9es)
- [3. Fonctionnement global du site](#3-fonctionnement-global-du-site)
- [4. Détail des contrôleurs principaux](#4-d%C3%A9tail-des-contr%C3%B4leurs-principaux)
- [5. Gestion des clients](#5-gestion-des-clients)
- [6. Gestion des commandes](#6-gestion-des-commandes)
- [7. Gestion des paiements et de la comptabilité](#7-gestion-des-paiements-et-de-la-comptabilit%C3%A9)
- [8. Gestion des objets](#8-gestion-des-objets)
- [9. Génération et gestion des factures](#9-g%C3%A9n%C3%A9ration-et-gestion-des-factures)
- [10. Sécurité et gestion des accès](#10-s%C3%A9curit%C3%A9-et-gestion-des-acc%C3%A8s)
- [11. Exemples de flux de données](#11-exemples-de-flux-de-donn%C3%A9es)

---

## 1. Présentation générale

CICA est une application Laravel de gestion de pressing permettant de gérer les commandes, clients, paiements, objets (vêtements), factures, retraits et la comptabilité. Elle propose des interfaces pour les utilisateurs (clients) et les administrateurs, avec des fonctionnalités adaptées à chaque rôle.

---

## 2. Structure de la base de données

### Tables principales

#### `users`
| Colonne           | Type        | Description                                 |
|-------------------|-------------|---------------------------------------------|
| id                | int         | Identifiant unique                          |
| name              | string      | Nom du client ou de l’admin                 |
| email             | string      | Email (optionnel pour client)               |
| numero_whatsapp   | string      | Numéro WhatsApp du client                   |
| is_admin          | boolean     | 1 = admin, 0 = client                       |
| ...               | ...         | ...                                         |

#### `commandes`
| Colonne         | Type      | Description                                 |
|-----------------|-----------|---------------------------------------------|
| id              | int       | Identifiant unique                          |
| user_id         | int       | Référence au client (`users.id`)            |
| numero          | string    | Numéro unique de la commande                |
| client          | string    | Nom du client (copie, pour historique)      |
| numero_whatsapp | string    | Numéro WhatsApp du client                   |
| date_depot      | date      | Date de dépôt                               |
| date_retrait    | date      | Date de retrait prévue                      |
| total           | decimal   | Montant total de la commande                |
| avance_client   | decimal   | Montant déjà payé (acompte)                 |
| solde_restant   | decimal   | Montant restant à payer                     |
| statut          | string    | Statut (Non retirée, Retiré, etc.)          |
| ...             | ...       | ...                                         |

#### `commande_objets`
| Colonne      | Type    | Description                                 |
|--------------|---------|---------------------------------------------|
| id           | int     | Identifiant unique                          |
| commande_id  | int     | Référence à la commande                     |
| objet_id     | int     | Référence à l’objet                         |
| quantite     | int     | Quantité de l’objet                         |

#### `objets`
| Colonne        | Type    | Description                                 |
|---------------|---------|---------------------------------------------|
| id            | int     | Identifiant unique                          |
| nom           | string  | Nom de l’objet (ex : chemise)               |
| prix_unitaire | decimal | Prix unitaire                               |

#### `commande_payments`
| Colonne        | Type    | Description                                 |
|---------------|---------|---------------------------------------------|
| id            | int     | Identifiant unique                          |
| commande_id   | int     | Référence à la commande                     |
| user_id       | int     | Qui a enregistré le paiement                |
| amount        | decimal | Montant payé                                |
| payment_method| string  | Méthode (espèces, mobile money, etc.)       |
| payment_type  | string  | Type (Acompte, Complément, Validation)      |
| created_at    | date    | Date du paiement                            |

#### `facture_messages`
| Colonne | Type   | Description                  |
|---------|--------|------------------------------|
| id      | int    | Identifiant unique           |
| message | text   | Message personnalisé         |
| actif   | bool   | Affiché sur la facture       |

#### `notes`
| Colonne      | Type    | Description                                 |
|--------------|---------|---------------------------------------------|
| id           | int     | Identifiant unique                          |
| commande_id  | int     | Référence à la commande (optionnel)         |
| note         | text    | Remarque ou mouvement de caisse             |
| created_at   | date    | Date de la note                             |

---

## 3. Fonctionnement global du site

### a. Authentification
- Inscription, connexion, gestion du profil, déconnexion.
- Les admins ont un accès étendu à toutes les données.

### b. Création et gestion des clients
- Lors de la création d’une commande, le client est soit sélectionné (s’il existe), soit créé automatiquement avec ses informations (nom, WhatsApp, etc.).
- Les clients sont stockés dans la table `users` (avec `is_admin = 0`).
- Chaque commande référence le client via `user_id`.

### c. Gestion des commandes
- Création, modification, suppression de commandes.
- Ajout d’objets à la commande via la table pivot `commande_objets`.
- Suivi du statut, des paiements, du solde restant.

### d. Paiements et comptabilité
- Paiement d’acompte, compléments, validation (solde final).
- Chaque paiement est enregistré dans `commande_payments`.
- La comptabilité affiche tous les mouvements financiers.

### e. Factures
- Génération dynamique de factures PDF à partir des données de la commande et du client.
- Les factures ne sont pas stockées en base : elles sont générées à la demande.
- Les informations de la facture sont issues des tables `commandes`, `users`, `commande_objets`, `objets`, et `commande_payments`.

### f. Objets
- Gestion des types d’objets (vêtements, etc.) et de leurs prix par l’admin.

### g. Tableaux de bord
- Statistiques, listes filtrées, totaux, etc.

---

## 4. Détail des contrôleurs principaux

### `CommandeController`
- Gère la création, l’affichage, la modification, la suppression des commandes côté utilisateur.
- Méthodes clés :
  - `store` : création d’une commande (création du client si besoin, ajout des objets, calcul du total, enregistrement de l’acompte si fourni).
  - `valider` : validation/retrait de la commande, enregistrement du paiement final si solde restant.
  - `updateFinancial` : gestion des paiements complémentaires.
  - `printListeCommandes`, `printListeCommandesPending`, etc. : génération des vues PDF.

### `AdminController`
- Gère toutes les opérations côté admin (commandes, utilisateurs, objets, comptabilité, etc.).
- Méthodes clés :
  - `storeCommandeAdmin` : création de commande par l’admin (même logique que côté utilisateur).
  - `valider` : validation/retrait d’une commande, enregistrement du paiement de validation.
  - `comptabilite`, `printComptabilite` : affichage et export de la comptabilité.
  - `editObjets`, `updateObjets` : gestion des objets.

### `FactureController` (ou méthodes associées)
- Génère les factures PDF à partir des données de la commande et du client.
- Utilise les vues Blade et la librairie DomPDF.

---

## 5. Gestion des clients
- Création automatique lors de la saisie d’une commande si le client n’existe pas (vérification par numéro WhatsApp ou nom).
- Stockage dans la table `users`.
- Association à chaque commande via `user_id`.
- Les informations du client sont recopiées dans la commande pour l’historique (nom, numéro).

---

## 6. Gestion des commandes
- Chaque commande référence un client, une liste d’objets, un statut, un total, un acompte, un solde restant.
- Les objets sont liés via la table pivot `commande_objets`.
- Les paiements sont enregistrés dans `commande_payments`.
- Le statut évolue selon les paiements : “Non retirée”, “Partiellement payé”, “Retiré”, etc.

---

## 7. Gestion des paiements et de la comptabilité
- Paiements enregistrés à chaque étape (acompte, complément, validation).
- Chaque paiement a un type et une méthode.
- La comptabilité affiche tous les paiements, filtrables par date, type, etc.
- Les retraits d’argent (sorties de caisse) sont enregistrés dans `notes`.

---

## 8. Gestion des objets
- Les objets (vêtements, etc.) sont gérés par l’admin.
- Ajout, modification, suppression via l’interface admin.
- Chaque objet a un nom et un prix unitaire.

---

## 9. Génération et gestion des factures
- Les factures sont générées dynamiquement à partir des données de la commande, du client, des objets et des paiements.
- Elles ne sont pas stockées en base, mais générées à la demande (PDF).
- Les messages personnalisés sont ajoutés via la table `facture_messages`.
- Les factures sont accessibles depuis la page de détail de la commande.

---

## 10. Sécurité et gestion des accès
- Middleware pour restreindre l’accès aux routes admin.
- Validation des données à chaque étape (formulaires, paiements, etc.).
- Protection CSRF sur tous les formulaires.

---

## 11. Exemples de flux de données

### a. Création d’une commande (utilisateur ou admin)
1. Saisie des infos client (nom, WhatsApp, etc.).
2. Vérification si le client existe : sinon, création dans `users`.
3. Création de la commande dans `commandes` (avec user_id, total, etc.).
4. Ajout des objets dans `commande_objets`.
5. Saisie d’un acompte (optionnel) : enregistrement dans `commande_payments`.
6. Statut initial : “Non retirée” ou “Partiellement payé”.

### b. Paiement complémentaire
1. L’utilisateur complète le paiement via un formulaire.
2. Enregistrement du paiement dans `commande_payments`.
3. Mise à jour du solde restant dans `commandes`.
4. Si solde = 0, la commande peut être validée (statut “Retiré”).

### c. Génération d’une facture
1. L’utilisateur ou l’admin clique sur “Télécharger la facture”.
2. Les données sont récupérées depuis `commandes`, `users`, `commande_objets`, `objets`, `commande_payments`.
3. La facture est générée en PDF et proposée au téléchargement.

---

**Pour toute question sur un point précis, voir les fichiers du dossier `app/Http/Controllers/` ou demander un exemple de code !** 