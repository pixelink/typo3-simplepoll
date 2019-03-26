.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _admin-manual:

Administrator Manual
====================


Installation
------------

- Install the SimplePoll Extension in the **Extension Manager**
- Include the Template by selecting **Template** and the root of your site. Then click on **Edit the whole template record**
- In the **Include** tab select ``Simple Poll Extension (simplepoll)`` on the right side of the **Include static (from extensions):** selection box.
.. figure:: ../Images/AdministratorManual/AdministratorsManual_includeTemplate.jpg
	:width: 500px

	Include the SimplePoll template
- Create a new folder/page that should be the storage location of the SimplePoll elements.
- Check the ID of the new folder.
.. figure:: ../Images/AdministratorManual/AdministratorsManual_pollFolder.jpg
	:width: 346px

	New folder and its ID
- Select **Template** and the root of your site and choose **Constant Editor** in the Template tools top select menu.
- Choose **PLUGIN.TX_SIMPLEPOLL** under **Category**
- Change the **Default storage PID** to the ID of the folder you created above.
.. figure:: ../Images/AdministratorManual/AdministratorsManual_storagePid.jpg
	:width: 500px

	Set the Storage PID
- Save the document

You are ready to go now.

Configuration
-------------

These are the values you can change in the **Constant Editor** or in your TypoScript

Path to template layouts (FE) - ``[plugin.tx_simplepoll.view.layoutRootPath]``
	Path to template layouts (FE)
|
Path to template partials (FE) - ``[plugin.tx_simplepoll.view.partialRootPath]``
	Path to template partials (FE)
|
Path to template root (FE) - ``[plugin.tx_simplepoll.view.templateRootPath]``
	Path to template root (FE)
|
Default storage PID - ``[plugin.tx_simplepoll.persistence.storagePid]``
	This is the ID of the folder/page where the SimplePoll elements are stored. Be sure to set this correctly!
|
Show the results after voting - ``[plugin.tx_simplepoll.settings.showResultAfterVote]``
	Show the results after voting
|
Show the results if not allowed to vote - ``[plugin.tx_simplepoll.settings.showResultIfNotAllowedToVote]``
	If the User already voted and currently is not allowed to vote again he is forwarded to the results. This is overridden by 'showResultAfterVote'. Default is false, so we keep consistency with old versions.
|
Have the link button to the results without voting - ``[plugin.tx_simplepoll.settings.showResultLink]``
	Have the link button to the results without voting
|
Count Languages Seperately - ``[plugin.tx_simplepoll.settings.countLanguagesSeperately]``
	Decides wheter the results in a multi language page should be displayed per language chosen or if all results shouls be added up to generate a result that includes all votes for all languages
|
Use Typoscript settings instead of plugin values - ``[plugin.tx_simplepoll.settings.useTyposcriptSettings]``
	If you load the extension via bootstrapper you might want to use this option. It then takes the settings from TypoScript instead of the values in the plugins content element.
|
Allow another vote after the garbageCollectorInterval has ended - ``[plugin.tx_simplepoll.settings.allowMultipleVote]``
	This is the setting to allow multiple votes
|
Use the jQuery from this extension - ``[plugin.tx_simplepoll.settings.useInternalJquery]``
	Option to use the internal jQuery or the one already loaded by the site
|
Time in seconds before IP Locks are removed and a user can vote again if allowed - ``[plugin.tx_simplepoll.settings.garbageCollectorInterval]``
	Time in seconds before IP Locks are removed and a user can vote again if allowed
|
Block multiple votes from one IP address - ``[plugin.tx_simplepoll.settings.ipBlock]``
	If you allow multiple votes, this decides whether to do the blocking by the users IP address. (IP block overrules cookie block)
|
Block multiple votes from one computer via cookies - ``[plugin.tx_simplepoll.settings.cookieBlock]``
	Use this option and not the IP block, if you want to allow e.g. companies to vote. (they have only one IP and that one will get blocked after the first vote).

	Note that this method is a lot less secure than the IP block. If a cookie block is enabled a check is performed if the users browser accepts cookies.
|

Load simplepoll via Typoscript
------------------------------

You can load the simplepoll Plugin by using the following Typoscript lib:

.. code-block:: typoscript

	lib.loadSimplepoll = USER
	lib.loadSimplepoll {
		userFunc = TYPO3\CMS\Extbase\Core\Bootstrap->run
		extensionName = Simplepoll
		pluginName = Polllisting
		vendorName = Pixelink

		switchableControllerActions {
			SimplePoll {
				1 = list
			}
		}

        settings < plugin.tx_simplepoll.settings
		settings {
			simplepoll {
				useStdWrap := addToList(uid)
				uid = 1
			}
		}
	}

Call ``lib.loadSimplepoll`` with the following code in your fluid template:

.. code-block:: html

	<f:cObject typoscriptObjectPath="lib.loadSimplepoll">2</f:cObject>

This example will load the poll with the uid 2.


























