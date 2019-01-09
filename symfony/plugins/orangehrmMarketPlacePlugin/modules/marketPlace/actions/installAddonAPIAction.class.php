<?php
/**
 * OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 OrangeHRM Inc., http://www.orangehrm.com
 *
 * OrangeHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * OrangeHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA 02110-1301, USA
 */

/**
 * Class installAddonAPI
 */
class installAddonAPIAction extends baseAddonAction
{
    /**
     * @param sfRequest $request
     * @return mixed|string
     * @throws CoreServiceException
     * @throws sfStopException
     */
    public function execute($request)
    {
        try {
            $addonList = $this->getAddons();
            $data = $request->getParameterHolder()->getAll();
            $addonId = $data['installAddonID'];
            $addonURL = null;
            $addonDetail = null;
            foreach ($addonList as $addon) {
                if ($addon['id'] == $addonId) {
                    $addonDetail = $addon;
                    $addonURL = $addon['links']['file'];
                }
            }
            $result = $this->getAddonFile($addonURL, $addonDetail);
            echo json_encode($result);
            return sfView::NONE;
        } catch (GuzzleHttp\Exception\ConnectException $e) {
            echo json_encode(self::ERROR_CODE_NO_CONNECTION);
            return sfView::NONE;
        } catch (Exception $e) {
            echo json_encode(self::ERROR_CODE_EXCEPTION);
            return sfView::NONE;
        }
    }

    /**
     * @param $addonURL
     * @param $addonDetail
     * @throws CoreServiceException
     * @throws DaoException
     */
    private function getAddonFile($addonURL, $addonDetail)
    {
        $addonfile = $this->getApiManagerService()->getAddonFile($addonURL);
        return $this->installAddon($addonfile, $addonDetail);
    }

    /**
     * @param $addon
     * @param $addonDetail
     * @throws DaoException
     */
    protected function installAddon($addon, $addonDetail)
    {
        $data = array(
            'id' => $addonDetail['id'],
            'addonName' => $addonDetail['title'],
            'status' => 'Installed'
        );
        $result = $this->getMarcketplaceService()->installOrRequestAddon($data);
//                Todo implementation on instalation
    }
}