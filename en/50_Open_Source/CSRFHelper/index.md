CSRF Helper is a tool for MODX to secure forms against cross-site request forgery (CSRF) vulnerabilities, brought to you by [modmore](https://modmore.com/).

[TOC]

## What's a CSRF vulnerability?

The [Open Web Application Security Project (OWASP) explains CSRF](https://www.owasp.org/index.php/Cross-Site_Request_Forgery_(CSRF)) as follows:

> Cross-Site Request Forgery (CSRF) is an attack that forces an end user to
execute unwanted actions on a web application in which they're currently authenticated.
CSRF attacks specifically target state-changing requests, not theft of data, since the
attacker has no way to see the response to the forged request.

> With a little help of social engineering (such as sending a link via email or chat),
an attacker may trick the users of a web application into executing actions of the
attacker's choosing.

> If the victim is a normal user, a successful CSRF attack can force the user to perform
state changing requests like transferring funds, changing their email address, and so forth.
If the victim is an administrative account, CSRF can compromise the entire web application.

Forms that are vulnerable to CSRF can be executed by an attacker as another (authenticated) user. This requires that
the user can be tricked into executing the action from their browser, for example by visiting a compromised site
or a link that exploits a cross-site-scripting (XSS) vulnerability. 

Most CSRF attacks are thus targeted. They are also specific to a site, as the attacker will need to craft a specific
request for specific sites and forms. This makes CSRF a lower risk vulnerability to the average site compared to, say,
a SQL injection or persisted XSS that impacts all visitors of a site. 

You should however care about CSRF vulnerabilities if authenticated users can execute actions that can impact your
site, their usage of the site, or lead to other vulnerabilities. 

For example, a simple contact form that only sends information via email that the user submits is not as vulnerable
as a form  that lets the user change the email address or other personal information associated with their account. 
The latter could lead to an account being taken over by an attacker, while the first is just spam. 

The benefit of implementing CSRF Helper on less vulnerable forms (like contact forms) comes from its potential to help
protect against spam. An unprotected form can easily be hammered by an attacker/spammer, while a protected form requires
the attacker to at the very least request the page containing the form over and over again and interact with it.  

## How does CSRF Helper protect against CSRF?

With CSRF Helper you can add CSRF protection to any form built with FormIt, as well as forms for the Login package.
It's also possible, though currently not documented, to use the PHP classes at the core of CSRF Helper to verify tokens
in custom form handlers.

The CSRF protection works by generating what's known as a CSRF token, a random hash that is stored in a users' session,
and which needs to be present and correct in a form submission. As an attacker cannot know this token in advance, they
are unable of executing a valid form submission. 

Other types of vulnerabilities (in particular XSS or clickjacking) may bypass this CSRF protection, but CSRF tokens do
add a very valuable layer of protection. 

## Download & Installation

CSRFHelper is free to use, and licensed under the MIT License. [Source code and issue tracker are on GitHub](https://github.com/modmore/csrfhelper). 

Installable packages are available from both [modmore](https://modmore.com/extras/csrfhelper/) and [MODX](https://modx.com/extras/package/csrfhelper), through your site's package manager. After installation, look at the specific documentation for the type of form you're looking to protect for examples and instructions.

## Usage

After installing the extra, you get access to some new snippets: 

- `csrfhelper` returns a CSRF token that you need to insert into the form (typically as a hidden input with name `csrf_token`) that is submitted along with the request.
- `csrfhelper_formit` is meant to be used as a FormIt hook to validate the `csrf_token` variable.
- `csrfhelper_login` is meant to be used as a hook on snippets provided by Login (Login, Register, UpdateProfile) to validate the `csrf_token` variable in those requests.

The **csrfhelper** snippet is used to generate the token. The other snippets are used for validating the token with specific tools. 

- [Protecting FormIt forms against CSRF](FormIt)
- Login:
    - [Protecting login forms against CSRF](Login/Login)
    - [Protecting registration forms against CSRF](Login/Register)
    - [Protecting update profile forms against CSRF](Login/UpdateProfile)
    - [Protecting change password forms against CSRF](Login/ChangePassword)

### csrfhelper snippet

The csrfhelper snippet generates the token for most uses.

It accepts the following properties:

- **`key`**: required, the identifier for the token. This should be unique for most forms. 
- **`singleUse`**: optional, when set to 1 the token will only be valid for one request. Subsequent requests will generate a new token. Recommended for sensitive forms or forms that have a destructive outcome. 

### csrfhelper_formit snippet

Used as hook for FormIt. 

- Accepts a `csrfKey` property that should match the `key` property on `csrfhelper`. 
- Expects the token to be provided in a field named `csrf_token`
- Validation errors are set to the `[[!+fi.error.csrf_token]]` placeholder

[Learn how to protect your FormIt forms](FormIt)

### csrfhelper_login snippet

Used as hook for snippets that come with the Login package, including Login, Register, UpdateProfile and ChangePassword. 

- Accepts a `csrfKey` property that should match the `key` property on `csrfhelper`. 
- Expects the token to be provided in a field named `csrf_token`
- Validation errors are returned to the respective snippet with no specific placeholder needed. See the documentation for each snippet for the placeholder that contains the error; these placeholders are already present in the default templates. 

[Learn how to protect your Login forms](Login/Login)

