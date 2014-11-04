Google Custom Search Module for SilverStripe
============================================
A simple extension to add a Google Custom Search to your SilverStripe template.

Developer
-----------------------------------------------
Nicolaas Francken [at] sunnysideup.co.nz


Requirements
-----------------------------------------------
see composer.json


Documentation
-----------------------------------------------
Please contact author for more details.

Any bug reports and/or feature requests will be
looked at in detail

We are also very happy to provide personalised support
for this module in exchange for a small donation.


Installation Instructions
-----------------------------------------------

1. Find out how to add modules to SS and add module as per usual.

2. Review configs and add entries to mysite/_config/config.yml
(or similar) as necessary.
In the _config/ folder of this module
you can usually find some examples of config options (if any).

3. add <% include GoogleSiteSearchForm %> to any of your templates

4. Make sure to run /dev/build/?flush=all

4. create / edit the GoogleCustomSearchPage in your CMS (should be created automagically).

5. to customise, you can edit / theme the following files:
   * googlecustomsearch/css/GoogleCustomSearchPage.css
   * replace methods and variables in the Javascript files
   * theme the templates
   * extend the GoogleCustomSearchPage as per usual


Setting up a Google Custom Search Account
-----------------------------------------------
* Go to https://www.google.com/cse/create/ and create your search engine
* Select the look and feel, configure all the options
* If you click on the "Basics" link, you will see your Search engine unique ID
* You will also need to:

    a. pay for your custom google search engine OR

    b. setup a google API key (this was a real pain to do!)


Super useful links (you are gonna need this ;-))
-----------------------------------------------
* https://developers.google.com/custom-search/docs/element
* https://developers.google.com/custom-search/json-api/v1/introduction
* https://developers.google.com/custom-search/json-api/v1/using_rest
* http://developers.google.com/apis-explorer/#p/customsearch/v1/
* http://developers.google.com/apis-explorer/#p/customsearch/v1/search.cse.list
* https://console.developers.google.com/project
* https://www.google.com/cse/all
* https://www.google.com/cse/create/fromkwsetname
* https://duckduckgo.com/api
