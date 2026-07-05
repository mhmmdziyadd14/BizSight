<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\UserAccess;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // 1. Sync trial extension slugs with current config values (Self-healing mechanism)
        $pccBumpId = config('services.scalev.pcc_bump_id') ?: 'pcc_bump_id_placeholder';
        $vcpBumpId = config('services.scalev.vcp_bump_id') ?: 'vcp_bump_id_placeholder';
        $deBumpId = config('services.scalev.de_bump_id') ?: 'de_bump_id_placeholder';

        Product::where('name', 'Decision Engine - 30 Days Extension')
            ->where('slug', '!=', $pccBumpId)
            ->update(['slug' => $pccBumpId]);

        Product::where('name', 'Profit Clarity Calculator - 30 Days Extension (VCP Buyer)')
            ->where('slug', '!=', $vcpBumpId)
            ->update(['slug' => $vcpBumpId]);

        Product::where('name', 'Profit Clarity Calculator - 30 Days Extension (DE Buyer)')
            ->where('slug', '!=', $deBumpId)
            ->update(['slug' => $deBumpId]);

        $user = auth()->user();

        // Retrieve all active products
        $allProducts = Product::where('is_active', true)->get();

        $lifetimeProducts = [];
        $trialExtensions = [];

        foreach ($allProducts as $product) {
            $features = $product->features ?? [];
            
            // Check if user already has lifetime access to ALL features in this product
            $hasAllLifetime = true;
            if (empty($features)) {
                $hasAllLifetime = false;
            } else {
                foreach ($features as $featureCode) {
                    $hasAccess = UserAccess::where('user_id', $user->id)
                        ->where('feature_code', strtolower($featureCode))
                        ->where('is_trial', false)
                        ->exists();

                    if (!$hasAccess) {
                        $hasAllLifetime = false;
                        break;
                    }
                }
            }

            // Filter out products they already own as lifetime
            if ($hasAllLifetime) {
                continue;
            }

            if ($product->type === 'trial_extension') {
                $feature = strtolower($features[0] ?? '');
                $existingTrial = UserAccess::where('user_id', $user->id)
                    ->where('feature_code', $feature)
                    ->where('is_trial', true)
                    ->first();

                $product->existing_trial = $existingTrial;
                
                // Add scalev link mapping dynamically
                if ($product->name === 'Decision Engine - 30 Days Extension') {
                    $product->scalev_url = 'https://clarity-labs.myscalev.com/b/clarity-decision-special-offer-ciieye';
                } elseif (str_contains($product->name, 'VCP Buyer')) {
                    $product->scalev_url = 'https://clarity-labs.myscalev.com/b/clarity-design-special-offer-xpf7yb';
                } else {
                    $product->scalev_url = 'https://clarity-labs.myscalev.com/b/clarity-cost-special-offer-bsla5h';
                }

                $trialExtensions[] = $product;
            } else {
                // Add scalev link mapping dynamically for lifetime products
                if ($product->name === 'Visual Clarity Pack') {
                    $product->scalev_url = 'https://clarity-labs.myscalev.com/b/clarity-design-special-offer-xpf7yb';
                } elseif ($product->name === 'Profit Clarity Calculator') {
                    $product->scalev_url = 'https://clarity-labs.myscalev.com/b/clarity-cost-special-offer-bsla5h';
                } elseif ($product->name === 'Decision Engine') {
                    $product->scalev_url = 'https://clarity-labs.myscalev.com/b/clarity-decision-special-offer-ciieye';
                } elseif ($product->name === 'Clarity Essentials') {
                    $product->scalev_url = 'https://clarity-labs.myscalev.com/b/clarity-essentials-discount-uv5xls';
                } elseif ($product->name === 'Clarity Full') {
                    $product->scalev_url = 'https://clarity-labs.myscalev.com/b/clarity-full-hemat-158k-bayar-2-dapat-3-axys6d';
                }

                $lifetimeProducts[] = $product;
            }
        }

        return view('products.index', compact('lifetimeProducts', 'trialExtensions'));
    }
}
