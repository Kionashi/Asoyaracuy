<?php

namespace App\Http\Controllers\Admin\Management;

use App\Http\Controllers\Admin\RDNAdminController;
use App\Models\Contact as ContactModel;

class Contacts extends RDNAdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return admin.contacts.index
     */
    
    public function index()
    {
        // Load page size values
        $pageSizes = explode(",", $this->configItems['rdn.admin.paginator-sizes']);
        
        // Load paginator default value
        $pageDefault = $this->configItems['rdn.admin.paginator-default.value'];
        
        // Add breadcrumbs
        $this->addBreadcrumb('Contactos', route('management/contacts'));
        
        // Set Title and subtitle
        $this->title = 'Contactos';
        
        // Find all contact
        $contacts = ContactModel::with('contactReason')->get();
        
        // Display view
        return $this->view('pages.admin.management.contacts.index')
            ->with('contacts', $contacts)
            ->with('pageDefault', $pageDefault)
            ->with('pageSizes', $pageSizes);
        ;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return admin.contacts.detail
     */
    public function detail($id)
    {
        // Add breadcrumbs
        $this->addBreadcrumb('Contactos', route('management/contacts'));
        $this->addBreadcrumb('Detalle', route('management/contacts/detail',$id));
        
        // Set Title and subtitle
        $this->title = 'Contacto';
        $this->subtitle = 'entrada #'.$id;
        
        // Find product by id
        $contact = ContactModel::with('contactReason')->find($id);
        
        if ($contact) {
            // Display view
            return $this->view('pages.admin.management.contacts.detail')
                ->with('contact', $contact)
            ;
        } else {
            return response()->view('errors.admin.404');
        }
         
    }

}
