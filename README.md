# Audit Assignments

A report plugin for Moodle that allows authorised users to audit the courses in which they have been granted permission
to verify that assignments are being set regularly in those courses.

## Usage

Install by dropping into **report/assignaudit** in your Moodle installation. Go to **/admin/** in your browser to complete the installation.

Once installed, the _Audit Assignments_ option will appear under _Reports_ when you are in a course or category where you have the appropriate
permissions, and also under Site Administration if you are a site administrator.

From the interface, you are able to choose a time period to check, and select the courses which you want to look at. You then click **Show**, and see a list
of all the Assignment modules created in that time period in those courses.

## Permissions and Roles

This plugin will add a new capability called **report/assignaudit:audit**. Users who should have access to audit assignments should be added to a Moodle role of your
creation which has this capability. Alternatively, add the capability to an existing defined role.

The capability can be set in specific courses, or in a category of courses.

Site administrators will by default be able to audit assignment creation in all courses.

## TODO

 * Events for logging the usage of this feature
 * Icons in table?

## License

Licensed under the GNU General Public License v3.
