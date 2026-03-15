# Description
This project is a PHP + MySQL application that uses Recombee for product recommendations.
For security, the project uses sample tables.

---

## Important — Replace keys and passwords in project files
This project contains files that define connections to the MySQL database and the Recombee service.
All passwords, API keys, and sensitive data must be manually replaced by each user.

**Each user must enter their own:**
* MySQL / phpMyAdmin login
* Recombee Database ID
* Recombee Private Token
* Database name
* MySQL username and password

*These values ​​are not included in the project and must be filled in manually.*

---

## Database tables
The database included in the project contains sample tables, used to avoid exposing real data.
Each user must rename these tables, removing the `sample_` prefix from their names.

**Tables to be renamed:**
* `sample_produse` → `produse`
* `sample_utilizatori` → `utilizatori`
* `sample_cumparaturi` → `cumparaturi`
* `sample_favorites` → `favorites`
* `sample_istoric` → `istoric`
* `sample_review` → `review`

---

## Configuring Recombee scenarios
The application uses three recommendation scenarios, each with a different algorithm, page, and KPIs.
Each user must manually create these scenarios in the Recombee Dashboard.

### 1. How to create scenarios in Recombee
1. Log in to Recombee
2. Access the database created for the project
3. Go to **Scenarios** in the left menu
4. Click **Create new scenario**
5. Fill in the fields as described below
6. Save the scenario

### Required scenarios

#### **1. home_page**
* **Algorithm type:** Hybrid Filtering
* **Placement (page):** Home page
* **Implementation:**
  ```php
  new RecommendItemsToUser($userId, $k, ['scenario' => 'home_page']);

#### **2. product_detail**
* **Algorithm type:**  Collaborative Filtering (CF)
* **Placement (page):** Cart page
* **Implementation:**
  ```php
  new RecommendItemsToItem($itemId, $userId, $k, ['scenario' => 'product_detail']);

#### **3. cart**
* **Algorithm type:** Content‑Based Filtering (CBF)
* **Placement (page):** Product page
* **Implementation:**
  ```php
  new RecommendItemsToUser($userId, $k, ['scenario' => 'cart']);

