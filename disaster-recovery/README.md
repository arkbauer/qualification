# Disaster Recovery System

## Background

A currency exchange company's server room caught fire. The application is completely destroyed, but the accounting department had CSV exports from their daily backup routine.

Your mission: rebuild the core system and restore historical data so the business can continue operations.

---

## Data Files

You will receive three CSV files:

### clients.csv

Client profiles with optional tier locking (legacy sales deals).

```
client_id,name,registered_at,tier_locked,tier_locked_value
C001,Acme Corp,2019-03-15,,
C002,Swiss Trading GmbH,2021-07-22,1,GOLD
C003,Weekend Warriors Ltd,2020-11-08,,
```

| Field | Description |
|-------|-------------|
| client_id | Unique identifier |
| name | Company name |
| registered_at | Registration date |
| tier_locked | Flag indicating tier lock |
| tier_locked_value | Locked tier value (BRONZE/SILVER/GOLD) |

### rates.csv

Historical currency exchange rates.

```
source,target,rate,valid_from
EUR,USD,1.0847,2024-01-01
EUR,USD,1.0912,2024-01-15
EUR,CHF,0.9341,2024-01-01
USD,EUR,0.9219,2024-01-01
```

| Field | Description |
|-------|-------------|
| source | Source currency code |
| target | Target currency code |
| rate | Exchange rate |
| valid_from | Date from which rate is valid |

### transactions.csv

Historical transaction records with originally calculated values.

```
transaction_id,client_id,amount,source_currency,target_currency,created_at,refunded_at,original_fee,original_final_amount
T0001,C006,394.22,USD,GBP,2024-01-01 08:20:50,,7.02,305.20
T0002,C010,2497.20,USD,CHF,2024-01-01 09:25:32,,48.38,2101.71
T0003,C008,408.66,EUR,PLN,2024-01-01 09:45:40,,39.92,1734.48
```

| Field | Description |
|-------|-------------|
| transaction_id | Unique identifier |
| client_id | Reference to client |
| amount | Transaction amount in source currency |
| source_currency | Currency being exchanged from |
| target_currency | Currency being exchanged to |
| created_at | Transaction timestamp |
| refunded_at | Refund timestamp (empty if not refunded) |
| original_fee | Fee calculated by the old system (in target currency) |
| original_final_amount | Amount client received after fee deduction (in target currency) |

**Calculation Example:**

```
Transaction: 100.00 EUR → USD at rate 1.0850

Step 1: Convert currency
  100.00 EUR × 1.0850 = 108.50 USD (converted amount)

Step 2: Calculate fee (assuming SILVER tier at 2.25%)
  108.50 USD × 0.0225 = 2.44 USD (fee)

Step 3: Calculate final amount
  108.50 USD − 2.44 USD = 106.06 USD (final amount client receives)

In CSV:
  amount = 100.00
  original_fee = 2.44
  original_final_amount = 106.06
```

Note: `original_fee + original_final_amount = converted amount` (not the source amount)

---

## Tasks

### Task 1: Data Model & Import

Create Doctrine entities and a Symfony console command to import all three CSV files.

Requirements:
- Design appropriate entity relationships
- Log any data inconsistencies found during import (missing references, invalid data, etc.)

### Task 2: Rate Lookup Service

Implement a service method:

```php
public function getRate(string $source, string $target, \DateTimeInterface $date): ?string
```

Requirements:
- Return the applicable rate for a given date (most recent `valid_from` not exceeding the date)
- If direct currency pair doesn't exist, calculate from inverse pair

### Task 3: Fee Calculation Service

Implement fee calculation for transactions based on client tier.

**Fee Tiers** (determined by client's monthly transaction volume):

| Tier | Monthly Volume | Fee |
|------|----------------|-----|
| Bronze | €0 – €10,000 | 2.75% |
| Silver | €10,001 – €50,000 | 2.25% |
| Gold | €50,001+ | 1.75% |

**Special Rules:**

1. **Grace period**: If a client was Gold last month but has Bronze/Silver volume this month, Gold rate still applies for the first 15 calendar days of the current month
2. **Grace period exception**: Grace period does NOT apply if the client drops two tiers (Gold → Bronze)
3. **CHF preference**: Transactions involving CHF (either as source or target) always receive Silver rate as a minimum, regardless of calculated tier
4. **Locked tier**: Clients with a locked tier always use that tier, ignoring volume calculations
5. **Volume calculation**: Monthly volume excludes transactions that were refunded within 72 hours of the original transaction

### Task 4: Output Command

Create a console command that calculates and displays fee details for a given transaction:

```
php bin/console app:calculate-fee <transaction_id>
```

Expected output format:

```
Transaction: T0001
Client: Acme Corp
Amount: 100.00 EUR → USD
Rate: 1.0850
Converted: 108.50
Tier: SILVER
Fee: 2.44
Final: 106.06
```

Where:
- `Converted` = Amount × Rate
- `Fee` = Converted × Fee Rate
- `Final` = Converted − Fee (amount client receives)

### Task 5: Discrepancy Report

Create a console command that compares your calculated fees against the original values from the CSV:

```
php bin/console app:discrepancy-report
```

The command should only produce output if discrepancies are found. Example:

```
Discrepancies found: 2

T0234:
  Original fee: 12.33 | Calculated fee: 11.89
  Original final: 1456.22 | Calculated final: 1456.66

T0891:
  Original fee: 45.00 | Calculated fee: 45.01
  Original final: 892.10 | Calculated final: 892.09
```

If no discrepancies exist, output nothing (exit silently).

---

## Deliverables

1. Symfony 6+ application with Doctrine entities and migrations
2. CSV import console command
3. Rate lookup service
4. Fee calculation service with tier logic
5. Fee output console command
6. Brief README explaining:
   - How to set up and run the application
   - Any assumptions you made

---

## Submission

Submit as a Git repository with meaningful commit history showing your development process.

---

Good luck!
