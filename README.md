# WP Appspring Test

A custom WordPress plugin built as part of the Appspring technical test.  
This plugin fetches data from two external API endpoints (`/providers` and `/tags`), stores them using the WordPress Options API with caching, and displays the data in both the WordPress admin and frontend.

---

## 🚀 Features

- 🔌 **Modular Plugin Architecture**  
  Clean structure with separated classes for API handling, Admin panel, and Frontend template.

- 🔁 **External API Integration**  
  Connects to:
  - `https://signin.healthloftco.com/api/providers`
  - `https://signin.healthloftco.com/api/tags`

- 🧠 **Caching System**  
  Data is cached using WordPress options and refreshed automatically every 60 minutes.

- ⚙️ **Admin Dashboard**  
  Custom menu under `Appspring Data` shows a styled, filterable list of providers and tag bubbles. Now includes a searchable dropdown via Choices.js.

- 🌐 **Frontend Page**  
  Registers the `/providers` URL automatically using a custom page template. Displays providers with filtering and mobile-friendly layout.

- 🔽 **Searchable Dropdown Filter**  
  Both admin and frontend use an enhanced dropdown with live search (via Choices.js).

- 📱 **Mobile Responsive**  
  Provider cards are responsive, cleanly styled, and optimized for various screen sizes.

---

## 🧩 Shortcode Usage

To embed the list of providers anywhere on your site, simply use the following shortcode in any page, post, or block editor:
  [appspring_providers]