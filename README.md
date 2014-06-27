# PRLP
====

A Drupal 8 Port of Password Reset Landing Page (PRLP) https://www.drupal.org/project/prlp

## Description

This module enhances Drupal's out-of-the-box password reset landing page by
adding new password inputs beside the simple "Log In" button that you see
on that page. This way, users are made to enter a new password at the time
of logging in with the one-time login link. This way, they set the password
to something they can remember and don't have to keep resetting the password.

## Requirements
No special requirements other than Drupal 8.x core.

## Installation & Usage
See the screenshots for usage example. To use this module, simply download
and enable the module. Now whenever any user clicks on a password reset
one-time login link, they will also be forced to set a new password.

## Todo

- Tests
- Reset to default function on settings page
- Find a solution for $form['message']['#markup'] (line 49, prlp.module)
