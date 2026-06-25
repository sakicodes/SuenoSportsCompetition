# PROJECT_CONTEXT.md

# Prediction Competition Platform

## Project Goal

Build a self-hosted web application that allows a private group of users to participate in prediction competitions.

Initial use case:

* FIFA World Cup knockout-stage predictions

Future use cases:

* Other football tournaments
* Esports tournaments
* Formula 1
* Internal office competitions
* Generic bracket-based competitions

The platform should remain competition-agnostic and avoid hardcoding football-specific assumptions into the database design.

---

# Primary Learning Goals

This project exists primarily for learning:

* Backend Engineering
* Web Development
* Laravel
* PHP OOP
* MVC Architecture
* 3 Layer Architecture
* BCE (Boundary-Control-Entity)
* PostgreSQL
* Docker
* Nginx
* Linux Hosting
* Basic Security Practices

This is NOT intended to be a production-scale public application.

---

# Technology Stack

## Backend

* PHP 8.x
* Laravel

## Database

* PostgreSQL

## Reverse Proxy

* Nginx

## Containerization

* Docker
* Docker Compose

## Frontend

* Laravel Blade Templates
* Bootstrap

No SPA frameworks for V1:

* No React
* No Vue
* No Angular

Focus on backend engineering.

---

# Deployment Environment

Host:

* Fedora Linux Laptop

Deployment Method:

* Docker Compose

Preferred Access Method:

* Tailscale

Alternative:

* Port Forwarding

Reason:

Tailscale minimizes attack surface and avoids exposing services directly to the public Internet.

---

# High Level Architecture

Browser
↓
Nginx
↓
Laravel / PHP-FPM
↓
PostgreSQL

Docker Compose Services:

* nginx
* laravel
* postgres

Future optional services:

* redis
* scheduler
* queue-worker

Not required for V1.

---

# Architectural Style

Use MVC together with 3-Layer Architecture.

## MVC

Model

* Eloquent Models

View

* Blade Templates

Controller

* HTTP Controllers

---

## 3 Layer Architecture

Presentation Layer
↓
Domain Layer
↓
Data Layer

### Presentation Layer

Responsibilities:

* Controllers
* Blade Views
* Request Validation
* Authentication Views

Examples:

* Login Page
* Dashboard
* Leaderboard
* Prediction Pages
* Admin Pages

---

### Domain Layer

Contains business logic.

Examples:

* CompetitionService
* PredictionService
* ScoringService
* LeaderboardService
* UserService

No database queries should live here.

---

### Data Layer

Responsibilities:

* Eloquent Models
* Repositories
* Database Access

Examples:

* UserRepository
* CompetitionRepository
* MatchRepository
* PredictionRepository

---

# BCE Mapping

Boundary

* Controllers
* Views
* Form Requests

Control

* Services
* Business Rules

Entity

* User
* Competition
* Match
* Prediction
* Team
* Round

BCE should guide organization but should not be over-engineered.

---

# Functional Requirements

## User

Can:

* Login
* Logout
* Change password
* View profile
* View competitions
* View overall leaderboard
* View competition leaderboard
* View rounds
* View matches
* Submit predictions
* Edit predictions before lock
* View prediction history
* View personal point balance

Cannot:

* Create competitions
* Create matches
* Modify results
* Modify scoring configuration

---

## Admin

Can:

* Create users
* Create competitions
* Create teams
* Create rounds
* Create matches
* Add users to competitions
* Configure point rules
* Lock rounds
* Unlock rounds
* Update match results
* Close competitions
* Award points manually
* Deduct points manually

---

# User Flow

## User

Login

↓

Dashboard

Dashboard displays:

* Available competitions
* Overall leaderboard
* Current points

User selects competition

↓

Competition Details

Displays:

* Competition leaderboard
* Available rounds
* Competition information

User selects round

↓

Round Details

Displays:

* Matches
* Prediction status
* Lock information

User submits predictions

↓

Points deducted

↓

Wait for results

↓

Leaderboard updates

---

## Admin

Admin Login

↓

Admin Dashboard

Admin may:

* Create competitions
* Create teams
* Create rounds
* Create matches
* Create users
* Add users to competitions
* Configure scoring
* Resolve matches
* Lock rounds
* Unlock rounds
* Manage points

---

# Core Domain Model

## Users

Purpose:

System users.

Fields:

* id
* username
* password_hash
* role
* current_points
* first_login
* active
* created_at
* updated_at

Roles:

* ADMIN
* USER

Notes:

first_login forces password change.

---

## Teams

Purpose:

Competitors within a competition.

Fields:

* id
* name
* short_name
* active
* created_at
* updated_at

Examples:

* Brazil
* Germany
* Ferrari
* Team Liquid

---

## Competitions

Purpose:

Top-level competition container.

Fields:

* id
* name
* description
* status
* default_prediction_cost
* default_prediction_reward
* created_at
* updated_at

Status:

* OPEN
* CLOSED
* COMPLETED

Examples:

* World Cup 2026
* Euro 2028

---

## Competition Participants

Purpose:

Controls which users participate in a competition.

Fields:

* id
* competition_id
* user_id
* joined_at

Constraints:

Unique:

* competition_id
* user_id

---

## Rounds

Purpose:

Competition stages.

Fields:

* id
* competition_id
* name
* sequence
* prediction_cost
* prediction_reward
* prediction_lock_datetime
* locked
* created_at
* updated_at

Examples:

* Round of 32
* Round of 16
* Quarter Finals
* Semi Finals
* Third Place Match
* Final

Rules:

prediction_cost nullable

prediction_reward nullable

If null:

Use competition defaults.

---

## Matches

Purpose:

Actual competitive events.

Fields:

* id
* competition_id
* round_id
* home_team_id
* away_team_id
* winner_team_id
* match_datetime
* status
* created_at
* updated_at

Status:

* OPEN
* CLOSED
* COMPLETED

---

## Predictions

Purpose:

Stores user predictions.

Fields:

* id
* user_id
* match_id
* predicted_team_id
* points_spent
* points_awarded
* status
* created_at
* updated_at

Status:

* PENDING
* CORRECT
* INCORRECT

Constraints:

One prediction per user per match.

Unique:

(user_id, match_id)

Rules:

User may edit prediction until round lock.

---

## User Points Ledger

Purpose:

System of record for all point changes.

This table is the authoritative audit trail.

Fields:

* id
* user_id
* amount
* transaction_type
* reference_type
* reference_id
* notes
* created_at

Examples:

+100 Initial Allocation

-1 Prediction Cost

+2 Correct Prediction Reward

+20 Admin Bonus

-10 Admin Penalty

Transaction Types:

* INITIAL_ALLOCATION
* PREDICTION_COST
* PREDICTION_REWARD
* ADMIN_ADJUSTMENT

---

# Leaderboards

No dedicated leaderboard table.

Leaderboard is derived data.

Generate from:

* users
* predictions
* user_points_ledger

Benefits:

* No duplicated data
* Easier consistency
* Simpler maintenance

Possible Leaderboards:

* Overall Leaderboard
* Competition Leaderboard
* Round Leaderboard

---

# Point System

Default Example:

User:

100 points

Round Cost:

1 point

Round Reward:

2 points

Prediction submitted

100 → 99

Prediction correct

99 → 101

Prediction incorrect

99 → 99

Rules:

Users cannot submit predictions without sufficient points.

Admin may manually adjust points.

---

# Security Requirements

Application Scope:

Private friends-only system.

Data Stored:

* Username
* Password Hash

No personal information should be collected.

---

# Authentication Security

Requirements:

* Laravel Authentication
* bcrypt password hashing
* Session-based authentication
* CSRF protection
* Secure password change flow
* Role-based authorization

Never:

* Store plaintext passwords
* Store passwords in logs
* Commit secrets to Git

---

# Infrastructure Security

Preferred Deployment:

Tailscale

Advantages:

* No public IP exposure
* No port forwarding
* Smaller attack surface

If Port Forwarding is used:

Only expose:

* 443 HTTPS

Never expose:

* PostgreSQL
* Docker APIs
* Internal Services

---

# Frontend Guidelines

Use:

* Blade Templates
* Bootstrap

Priority:

Functionality over appearance.

Pages:

Public:

* Login

Authenticated:

* Dashboard
* Competition Page
* Round Page
* Prediction Page
* Profile Page
* Leaderboard Page

Admin:

* Competition Management
* Team Management
* User Management
* Match Management
* Point Management

---

# Design Decisions

Users may modify predictions before round lock.

Admin may manually award or deduct points.

Prediction cost is configurable.

Prediction reward is configurable.

Rounds may override competition defaults.

Leaderboard allows ties.

Users cannot view others' predictions before round lock.

Competitions remain generic.

Prediction deadlines are enforced per round.

Leaderboard is derived data.

User points are audited through ledger entries.

---

# Development Roadmap

## Phase 1

Infrastructure Setup

Tasks:

* Create Docker Compose
* Create Laravel Application
* Configure PostgreSQL
* Configure Nginx
* Verify container networking
* Verify Laravel DB connectivity

Deliverable:

Laravel Welcome Page running through Nginx.

---

## Phase 2

Authentication

Tasks:

* Login
* Logout
* Password Change
* User Roles

Deliverable:

Admin and User authentication working.

---

## Phase 3

Database Schema

Tasks:

* Migrations
* Models
* Relationships
* Seeders

Deliverable:

Domain model implemented.

---

## Phase 4

Admin Features

Tasks:

* Users
* Teams
* Competitions
* Rounds
* Matches

Deliverable:

Competition administration working.

---

## Phase 5

Prediction Features

Tasks:

* Submit Prediction
* Edit Prediction
* Point Deduction
* Validation

Deliverable:

Prediction workflow working.

---

## Phase 6

Scoring Engine

Tasks:

* Resolve Match
* Award Points
* Ledger Entries

Deliverable:

Automatic scoring working.

---

## Phase 7

Leaderboards

Tasks:

* Overall Leaderboard
* Competition Leaderboard
* Round Leaderboard

Deliverable:

Ranking system complete.

---

## Phase 8

Deployment

Tasks:

* Tailscale Setup
* Firewall Configuration
* Backup Strategy
* Production Configuration

Deliverable:

Friends can access application securely.

