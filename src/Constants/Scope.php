<?php
/**
 * Copyright: IMPER.INFO Adrian Szuszkiewicz
 * Date: 31.07.2019
 * Time: 18:50
 */

namespace Imper86\GoogleApiPhpSdk\Constants;


interface Scope
{
    const AUTH_USERINFO_EMAIL = 'https://www.googleapis.com/auth/userinfo.email';
    const AUTH_USERINFO_PROFILE = 'https://www.googleapis.com/auth/userinfo.profile';
    const DRIVE = 'https://www.googleapis.com/auth/drive';
    const BUSINESS_MANAGE = 'https://www.googleapis.com/auth/business.manage';
    const PLUS_BUSINESS_MANAGE = 'https://www.googleapis.com/auth/plus.business.manage';
    const PHOTOS_LIBRARY = 'https://www.googleapis.com/auth/photoslibrary';
    const PHOTOS_LIBRARY_APPENDONLY = 'https://www.googleapis.com/auth/photoslibrary.appendonly';
    const PHOTOS_LIBRARY_EDIT_APPCREATEDDATA = 'https://www.googleapis.com/auth/photoslibrary.edit.appcreateddata';
    const PHOTOS_LIBRARY_READONLY = 'https://www.googleapis.com/auth/photoslibrary.readonly';
    const PHOTOS_LIBRARY_READONLY_APPCREATEDDATA = 'https://www.googleapis.com/auth/photoslibrary.readonly.appcreateddata';
    const PHOTOS_LIBRARY_SHARING = 'https://www.googleapis.com/auth/photoslibrary.sharing';
}
