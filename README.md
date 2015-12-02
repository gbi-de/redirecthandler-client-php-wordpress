# Table of contents:

<ol>
  <li>Introduction</li>
  <li>Functionality of the redirect-handler</li>
  <li>Additional Features</li>
  <li>Requirements</li>
  <li>Optional extensions</li>
  <li>Advantage over the redirect by .htaccess</li>
  <li>Contact</li>
</ol>

## Introduction

### Websites are subject to permanent changes. 
Websites consist of several thousand pages and URLs, which are modified constantly. For example: products are added, changed or cease to exist or pages are (re)moved. This can also apply to project- or landing-pages.

Furthermore, relaunches take place every now and then.

### Inadequate handling of URLs can lead to a  massive loss in traffic! 
Problems originate from the removal of products and from relaunches. Both can cause "404-errors" (page not found).
When removing one or more products, the underlying page cannot be generated anymore.
A relaunch can invalidate multiple URLs at one go. 
**This will cause errors, if third parties want to retrieve the invalid URL!**
Examples: 
* bookmarks in the user's browser 
* links in blogs or bulletin boards.
* Search engines continuously try to re-index the contents of *memorized* URLs.

As a consequence, the users may be lost and will  leave the page, without searching for alternatives. External partners might not link to your website anymore.
Lost traffic has to be rebuilt and positive rankings for SEO are lost permanently.

## Functionality of the Redirect Handler
![Functionality of the redirect-handler](https://github.com/gbi-de/redirecthandler-doc/blob/master/rh-sequence.png?raw=true "Redirect Handler Sequence")

Background query while a '404-page' is displayed on our website. This will only be invoked if the page cannot be provided by the server anyway.

Over time, the redirect handler receives progressively less traffic for the "old" URL. This is because the clients (users, search engines) will remember and cache the new URL over time.

## Additional Features

### Analysis & Reporting
![Analysis & Reporting](https://github.com/gbi-de/redirecthandler-doc/blob/master/Analysis_and_Reporting.png?raw=true "Analysis & Reporting")
The reporting tools ensure a frequent optimization of the URL-managment. URLs that are reported as "404" can be subsequently added to URL-mappings and will thus operate as "redirects" (301) in the future.

### Regular Expressions
Regular Expressions and redirects are directly available and optimized for speed

### Huge Redirect Lists
We can serve redirects in real time with matching tables ranging in the hundreds of thousands of requests.


## Requirements
A script must be integtated on each web server that conducts "404-handling".
This script undertakes the (server-sided) synchronous communication with the redirect-handler.

The installation depends on the underlying CMS, shop- or system-structure.

## Advantage over other redirect methods

### Classic Redirects with pre-filtering (e.g. .htaccess):
* On the server-side, redirects are mostly processed via .htaccess
* Redirects are processed with each page request, so even requests that don't need to be redirected are handled. This leads to a small performance impact that adds up over time.
* The installation of the redirect-/matching-table via .htaccess is disadvantageous (performance-wise) for every single request, because the web-server processes the table without caching.
* Inadequate analysis of redirects and impact on other metrics like site performance or user behavior are not available. Revision Control / Versioning for redirects is not available.
* The matching-tables are normally maintained via Excel, meaning: no valid revision control, no reportings and no user interface for the maintenance of the redirect tables.
* Extended features like the evaluation of regular expressions and loop detection are generally not implemented or very slow.

### Redirect Handling by overriding the 404 Routines and using the Redirect Handler
* Valid "200" requests are never affected.
* Malfunctioning requests are enqueued for correction. Eventual slowdowns due to big matching tables affect only that portion of the traffic that is "invalid" anyway.
* The performance of the redirect-handler can be observed and optimized via the reporting tool. Corrupt links can be corrected in external systems.
* Matching tables can be generated automatically by us by periodically crawling your website and generating page histories through content matching.
* The redirect handler structure is specifically optimized to handle hundreds of thousands of redirects wihin milliseconds, even those with complex regular expressions.

# Contact

Find us on https://www.goldbachinteractive.de/ or contact us through mail to github@goldbach-interactive.de
