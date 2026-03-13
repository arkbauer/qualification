# Mini Hotel Reservation System — Test Task

## Overview

Build a small REST API or CLI that simulates a simplified hotel booking flow.

---

## Requirements

### Data Model

**Room**
- `id` — unique identifier
- `number` — room number (e.g. "101")
- `type` — `single` | `double` | `suite`
- `pricePerNight` — base price
- `isAvailable` — boolean

**Reservation**
- `id` — unique identifier
- `roomId`
- `guestName`
- `checkIn` — date (ISO 8601, e.g. `2026-04-01`)
- `checkOut` — date (ISO 8601, e.g. `2026-04-05`)
- `status` — `active` | `cancelled`
- `totalCost` — calculated at booking time

---

### Endpoints (or CLI commands)

#### Create a reservation
- Input: `roomId`, `guestName`, `checkIn`, `checkOut`
- Validate:
    - Up to you what to validate and how
- Pricing rules:
    - Base: `pricePerNight × nights`
    - 7+ nights: apply 10% discount
    - Suite type: apply 15% surcharge
    - Rules may combine
- Response: full reservation summary including breakdown

#### Cancel a reservation
- Input: `reservationId`
- Validate: reservation exists and is active
    - Up to you what to validate and how
- Mark as `cancelled`

#### List reservations
- Return all reservations
- Optional filter: by `roomId` or `status`

#### Get a reservation by ID
- Return a single reservation by ID

---

### Seed Data

Pre-populate at least 5 rooms of mixed types so the API is usable without setup.

---

## Constraints

- **No database required** — in-memory storage is perfectly fine
- **No authentication**
- **No persistence between restarts**
- **No frontend**
- PHP, any framework, or no framework

---

## Deliverable

A Git repository containing:

- Working implementation
- This README updated with:
    - How to install and run
    - How to run tests (if any)
    - A **Decisions & Tradeoffs** section (see below)

---

## Decisions & Tradeoffs

> Fill this section in before submitting.

Suggested prompts — answer what is relevant, skip what is not:

- What structure or architecture did you choose and why?
- What would you do differently with more time?
- What did you intentionally leave out and why?

---

## Evaluation Notes

There is no single correct solution. The Decisions & Tradeoffs section
carries significant weight — it tells us more about how you think than
the code itself.
