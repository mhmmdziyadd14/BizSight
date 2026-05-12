/**
 * @license
 * SPDX-License-Identifier: Apache-2.0
 */

import { useState, useRef, ChangeEvent } from 'react';
import { GoogleGenAI, Type } from "@google/genai";
import html2canvas from 'html2canvas';
import { jsPDF } from 'jspdf';
import { 
  Upload, 
  FileText, 
  BrainCircuit, 
  Layers, 
  ChevronRight, 
  Loader2, 
  CheckCircle2, 
  AlertCircle,
  Package,
  Cpu,
  ShieldCheck,
  Zap,
  Info
} from 'lucide-react';
import { motion, AnimatePresence } from 'motion/react';
import { TechpackResult } from './types';
import { SYSTEM_PROMPT, GENERATION_INSTRUCTIONS } from './constants';

const ai = new GoogleGenAI({ apiKey: process.env.GEMINI_API_KEY });

export default function App() {
  const [image, setImage] = useState<string | null>(null);
  const [file, setFile] = useState<File | null>(null);
  const [isAnalyzing, setIsAnalyzing] = useState(false);
  const [isExporting, setIsExporting] = useState(false);
  const [result, setResult] = useState<TechpackResult | null>(null);
  const [error, setError] = useState<string | null>(null);
  const fileInputRef = useRef<HTMLInputElement>(null);
  const resultRef = useRef<HTMLDivElement>(null);

  const handleImageUpload = (e: ChangeEvent<HTMLInputElement>) => {
    const selectedFile = e.target.files?.[0];
    if (selectedFile) {
      setFile(selectedFile);
      const reader = new FileReader();
      reader.onload = (event) => {
        setImage(event.target?.result as string);
        setResult(null);
        setError(null);
      };
      reader.readAsDataURL(selectedFile);
    }
  };

  const fileToBase64 = (file: File): Promise<string> => {
    return new Promise((resolve, reject) => {
      const reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onload = () => {
        const base64String = reader.result as string;
        resolve(base64String.split(',')[1]);
      };
      reader.onerror = (error) => reject(error);
    });
  };

  const analyzeProduct = async () => {
    if (!file) return;

    setIsAnalyzing(true);
    setError(null);

    try {
      const base64Data = await fileToBase64(file);
      
      const response = await ai.models.generateContent({
        model: "gemini-3-flash-preview",
        contents: {
          parts: [
            {
              inlineData: {
                mimeType: file.type,
                data: base64Data,
              },
            },
            {
              text: `${GENERATION_INSTRUCTIONS}\n\nPlease analyze this image and output the results in JSON format according to the following schema:\n${JSON.stringify({
                type: Type.OBJECT,
                properties: {
                  classification: { type: Type.OBJECT, properties: { productType: { type: Type.STRING }, categoryGroup: { type: Type.STRING }, style: { type: Type.STRING }, structure: { type: Type.STRING }, intendedUse: { type: Type.STRING } } },
                  functionAnalysis: { type: Type.OBJECT, properties: { purpose: { type: Type.STRING }, performanceRequirements: { type: Type.ARRAY, items: { type: Type.STRING } } } },
                  materialGeneration: { type: Type.OBJECT, properties: { primaryMaterial: { type: Type.OBJECT, properties: { mainFabric: { type: Type.STRING }, reason: { type: Type.STRING }, alternatives: { type: Type.ARRAY, items: { type: Type.STRING } } } }, secondaryMaterial: { type: Type.OBJECT, properties: { lining: { type: Type.STRING }, interfacing: { type: Type.STRING }, reinforcement: { type: Type.STRING } } }, accessories: { type: Type.OBJECT, properties: { mainHardware: { type: Type.STRING }, supportingComponents: { type: Type.ARRAY, items: { type: Type.STRING } } } }, construction: { type: Type.OBJECT, properties: { stitchType: { type: Type.STRING }, structureNotes: { type: Type.STRING } } } } },
                  categorySpecific: { type: Type.OBJECT, properties: { footwear: { type: Type.OBJECT, properties: { upper: { type: Type.STRING }, midsole: { type: Type.STRING }, outsole: { type: Type.STRING } } }, outerwear: { type: Type.OBJECT, properties: { outerLayer: { type: Type.STRING }, innerLayer: { type: Type.STRING }, insulation: { type: Type.STRING } } } } },
                  qualityTiers: { type: Type.OBJECT, properties: { basic: { type: Type.OBJECT, properties: { materials: { type: Type.STRING }, why: { type: Type.STRING } } }, midTier: { type: Type.OBJECT, properties: { materials: { type: Type.STRING }, why: { type: Type.STRING } } }, premium: { type: Type.OBJECT, properties: { materials: { type: Type.STRING }, why: { type: Type.STRING } } } } },
                  validation: { type: Type.OBJECT, properties: { compatibilityCheck: { type: Type.STRING }, manufacturabilityCheck: { type: Type.STRING } } }
                }
              })}`,
            },
          ],
        },
        config: {
          systemInstruction: SYSTEM_PROMPT,
          responseMimeType: "application/json",
        },
      });

      const parsedResult = JSON.parse(response.text || '{}') as TechpackResult;
      setResult(parsedResult);
    } catch (err) {
      console.error(err);
      setError("Failed to analyze product. Please ensure it's a valid fashion item and your API key is correctly configured.");
    } finally {
      setIsAnalyzing(false);
    }
  };

  const exportToPDF = async () => {
    if (!resultRef.current || !result) return;

    setIsExporting(true);
    try {
      const canvas = await html2canvas(resultRef.current, {
        scale: 2,
        useCORS: true,
        logging: false,
        backgroundColor: '#f8f9fa'
      });
      
      const imgData = canvas.toDataURL('image/png');
      const pdf = new jsPDF({
        orientation: 'portrait',
        unit: 'px',
        format: [canvas.width, canvas.height]
      });

      pdf.addImage(imgData, 'PNG', 0, 0, canvas.width, canvas.height);
      pdf.save(`techpack-${result.classification.productType.toLowerCase().replace(/\s+/g, '-')}.pdf`);
    } catch (err) {
      console.error('PDF Export Error:', err);
      setError("Failed to generate PDF. Please try again.");
    } finally {
      setIsExporting(false);
    }
  };

  return (
    <div className="min-h-screen p-4 md:p-8 max-w-6xl mx-auto space-y-8">
      {/* Header */}
      <header className="flex flex-col md:flex-row md:items-end justify-between gap-4 pb-6 border-b border-border-subtle">
        <div className="space-y-1">
          <div className="flex items-center gap-2 text-brand-accent mb-1">
            <Cpu size={20} />
            <span className="uppercase text-[10px] font-mono tracking-widest font-bold">Factory R&D System v2.1</span>
          </div>
          <h1 className="text-3xl font-bold tracking-tighter">FASHION TECHPACK AI</h1>
          <p className="text-brand-secondary text-sm">Automated Material Recommendation & Production Analysis</p>
        </div>
        <div className="flex items-center gap-4 text-[11px] font-mono text-brand-secondary">
          <div className="flex items-center gap-1">
            <div className="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse" />
            GENAI-FLASH-3.0
          </div>
          <div>EST. ANALYSIS: 4.2S</div>
        </div>
      </header>

      <main className="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        {/* Left Column: Upload & Preview */}
        <section className="lg:col-span-5 space-y-6">
          <div 
            className={`relative aspect-square glass-card flex flex-col items-center justify-center border-2 border-dashed transition-all cursor-pointer ${
              image ? 'border-transparent' : 'border-border-subtle hover:border-brand-accent'
            }`}
            onClick={() => fileInputRef.current?.click()}
          >
            {image ? (
              <img src={image} alt="Preview" className="w-full h-full object-cover rounded-xl" />
            ) : (
              <div className="flex flex-col items-center gap-4 text-brand-secondary">
                <div className="p-4 bg-surface-bg rounded-full border border-border-subtle shadow-inner">
                  <Upload size={32} />
                </div>
                <div className="text-center">
                  <p className="font-medium text-brand-primary">Upload Product Image</p>
                  <p className="text-xs">Drag and drop or click to browse</p>
                </div>
              </div>
            )}
            <input 
              type="file" 
              className="hidden" 
              accept="image/*" 
              ref={fileInputRef} 
              onChange={handleImageUpload} 
            />
          </div>

          <div className="flex gap-3">
            <button
              onClick={analyzeProduct}
              disabled={!file || isAnalyzing}
              className="flex-1 bg-brand-primary text-white py-3 rounded-lg font-medium flex items-center justify-center gap-2 hover:bg-black transition-colors disabled:opacity-50 disabled:cursor-not-allowed group"
            >
              {isAnalyzing ? (
                <>
                  <Loader2 className="animate-spin" size={20} />
                  Analyzing Textures...
                </>
              ) : (
                <>
                  <BrainCircuit size={20} className="group-hover:scale-110 transition-transform" />
                  Generate Techpack
                </>
              )
            }
            </button>
            {image && (
              <button 
                onClick={() => { setImage(null); setFile(null); setResult(null); }}
                className="px-4 py-3 border border-border-subtle rounded-lg hover:bg-white hover:text-red-600 transition-all"
              >
                Clear
              </button>
            )}
          </div>

          {error && (
            <motion.div 
              initial={{ opacity: 0, y: 10 }}
              animate={{ opacity: 1, y: 0 }}
              className="p-4 bg-red-50 border border-red-100 rounded-lg flex items-start gap-3 text-red-700 text-sm"
            >
              <AlertCircle size={18} className="shrink-0 mt-0.5" />
              <p>{error}</p>
            </motion.div>
          )}

          {/* Quick Guide */}
          <div className="p-4 bg-blue-50/50 border border-blue-100 rounded-lg space-y-3">
            <div className="flex items-center gap-2 text-blue-800 font-semibold text-xs uppercase tracking-wider">
              <Info size={14} />
              Analysis Protocol
            </div>
            <ul className="text-[12px] text-blue-700 space-y-2 opacity-80">
              <li className="flex items-center gap-2"><div className="w-1 h-1 rounded-full bg-blue-400" /> High-fidelity material classification</li>
              <li className="flex items-center gap-2"><div className="w-1 h-1 rounded-full bg-blue-400" /> Multi-tier manufacturing validation</li>
              <li className="flex items-center gap-2"><div className="w-1 h-1 rounded-full bg-blue-400" /> Standardized factory output format</li>
            </ul>
          </div>
        </section>

        {/* Right Column: Analysis Results */}
        <section className="lg:col-span-7">
          <AnimatePresence mode="wait">
            {!result && !isAnalyzing ? (
              <motion.div 
                key="empty"
                initial={{ opacity: 0 }}
                animate={{ opacity: 1 }}
                exit={{ opacity: 0 }}
                className="h-full min-h-[400px] glass-card flex flex-col items-center justify-center p-8 text-center text-brand-secondary space-y-4"
              >
                <div className="w-16 h-16 rounded-full bg-surface-bg flex items-center justify-center">
                  <Package size={32} strokeWidth={1.5} />
                </div>
                <div className="max-w-[280px]">
                  <h3 className="text-brand-primary font-medium mb-1">Waiting for Source Input</h3>
                  <p className="text-sm">Upload a garment or accessory image to trigger R&D material extraction.</p>
                </div>
              </motion.div>
            ) : isAnalyzing ? (
              <motion.div 
                key="loading"
                initial={{ opacity: 0 }}
                animate={{ opacity: 1 }}
                exit={{ opacity: 0 }}
                className="h-full min-h-[400px] glass-card p-8 space-y-8"
              >
                <div className="space-y-4">
                  <div className="h-8 bg-surface-bg animate-pulse rounded w-1/3" />
                  <div className="h-4 bg-surface-bg animate-pulse rounded w-1/2" />
                </div>
                <div className="grid grid-cols-2 gap-4">
                  {[1, 2, 3, 4].map(i => (
                    <div key={i} className="h-24 bg-surface-bg animate-pulse rounded-xl" />
                  ))}
                </div>
                <div className="h-40 bg-surface-bg animate-pulse rounded-xl w-full" />
              </motion.div>
            ) : (
              <motion.div 
                key="result"
                ref={resultRef}
                initial={{ opacity: 0, x: 20 }}
                animate={{ opacity: 1, x: 0 }}
                className="space-y-6"
              >
                {/* Product Classification */}
                <div className="glass-card p-6 overflow-hidden">
                  <div className="flex items-center justify-between mb-4">
                    <div className="flex items-center gap-2">
                      <Layers size={18} className="text-brand-accent" />
                      <h2 className="text-sm font-bold uppercase tracking-wider">Classification</h2>
                    </div>
                    <span className="bg-brand-primary text-white text-[10px] px-2 py-0.5 rounded uppercase font-mono">Verified</span>
                  </div>
                  
                  <div className="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    <div className="space-y-1">
                      <label className="text-[10px] uppercase text-brand-secondary font-semibold font-mono">Product</label>
                      <p className="text-sm font-medium">{result?.classification.productType}</p>
                    </div>
                    <div className="space-y-1">
                      <label className="text-[10px] uppercase text-brand-secondary font-semibold font-mono">Category</label>
                      <p className="text-sm font-medium">{result?.classification.categoryGroup}</p>
                    </div>
                    <div className="space-y-1">
                      <label className="text-[10px] uppercase text-brand-secondary font-semibold font-mono">Structure</label>
                      <p className="text-sm font-medium">{result?.classification.structure}</p>
                    </div>
                  </div>
                </div>

                {/* Primary Materials */}
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div className="glass-card p-6">
                    <h3 className="flex items-center gap-2 text-xs font-bold uppercase tracking-wider mb-4">
                      <Zap size={14} className="text-yellow-500" /> Primary Fabric
                    </h3>
                    <div className="space-y-4">
                      <div>
                        <div className="tech-info text-brand-accent mb-1">{result?.materialGeneration.primaryMaterial.mainFabric}</div>
                        <p className="text-xs text-brand-secondary leading-relaxed">{result?.materialGeneration.primaryMaterial.reason}</p>
                      </div>
                      <div className="space-y-2">
                        <label className="text-[10px] text-brand-secondary uppercase font-mono">Industry Alternatives</label>
                        <div className="flex flex-wrap gap-2">
                          {result?.materialGeneration.primaryMaterial.alternatives.map((alt, i) => (
                            <span key={i} className="text-[10px] bg-surface-bg px-2 py-1 rounded border border-border-subtle">{alt}</span>
                          ))}
                        </div>
                      </div>
                    </div>
                  </div>

                  <div className="glass-card p-6">
                    <h3 className="flex items-center gap-2 text-xs font-bold uppercase tracking-wider mb-4">
                      <ShieldCheck size={14} className="text-green-600" /> Hardware & Support
                    </h3>
                    <div className="space-y-4">
                      <div>
                        <div className="text-[10px] uppercase font-mono text-brand-secondary mb-1">Main Hardware</div>
                        <p className="text-sm font-medium">{result?.materialGeneration.accessories.mainHardware}</p>
                      </div>
                      <div className="grid grid-cols-2 gap-2">
                        {result?.materialGeneration.accessories.supportingComponents.map((comp, i) => (
                          <div key={i} className="flex items-center gap-2 text-[11px] text-brand-secondary">
                            <ChevronRight size={10} className="text-brand-accent" />
                            {comp}
                          </div>
                        ))}
                      </div>
                    </div>
                  </div>
                </div>

                {/* Secondary & Construction */}
                <div className="glass-card p-6 grid grid-cols-1 md:grid-cols-2 gap-8 relative overflow-hidden">
                  <div className="space-y-4 relative z-10">
                    <h3 className="text-xs font-bold uppercase tracking-wider">Internal Structure</h3>
                    <div className="space-y-3">
                      {result?.materialGeneration.secondaryMaterial.lining && (
                        <div>
                          <label className="text-[10px] uppercase text-brand-secondary font-mono">Lining</label>
                          <p className="text-xs leading-relaxed">{result.materialGeneration.secondaryMaterial.lining}</p>
                        </div>
                      )}
                      {result?.materialGeneration.secondaryMaterial.interfacing && (
                        <div>
                          <label className="text-[10px] uppercase text-brand-secondary font-mono">Interfacing</label>
                          <p className="text-xs leading-relaxed">{result.materialGeneration.secondaryMaterial.interfacing}</p>
                        </div>
                      )}
                    </div>
                  </div>
                  <div className="space-y-4 relative z-10">
                    <h3 className="text-xs font-bold uppercase tracking-wider">Construction</h3>
                    <div className="space-y-3">
                      <div>
                        <label className="text-[10px] uppercase text-brand-secondary font-mono">Stitch Policy</label>
                        <p className="text-xs leading-relaxed">{result?.materialGeneration.construction.stitchType}</p>
                      </div>
                      <div>
                        <label className="text-[10px] uppercase text-brand-secondary font-mono">Notes</label>
                        <p className="text-xs leading-relaxed line-clamp-2">{result?.materialGeneration.construction.structureNotes}</p>
                      </div>
                    </div>
                  </div>
                  {/* Subtle background icon */}
                  <div className="absolute -bottom-8 -right-8 opacity-[0.03] text-brand-primary pointer-events-none">
                    <FileText size={160} />
                  </div>
                </div>

                {/* Quality Tiers */}
                <div className="space-y-3">
                  <h3 className="text-xs font-bold uppercase tracking-wider px-2">Manufacturing Tiers</h3>
                  <div className="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    {/* Basic */}
                    <div className="glass-card p-4 space-y-2 border-l-4 border-l-slate-300">
                      <div className="text-[10px] font-bold uppercase font-mono text-slate-500">Tier 01: BASIC</div>
                      <div className="text-[11px] font-medium leading-tight">{result?.qualityTiers.basic.materials}</div>
                      <p className="text-[10px] text-brand-secondary font-mono uppercase tracking-tighter opacity-70">Industrial / Mass</p>
                    </div>
                    {/* Mid */}
                    <div className="glass-card p-4 space-y-2 border-l-4 border-l-blue-400">
                      <div className="text-[10px] font-bold uppercase font-mono text-blue-600">Tier 02: MID-RANGE</div>
                      <div className="text-[11px] font-medium leading-tight">{result?.qualityTiers.midTier.materials}</div>
                      <p className="text-[10px] text-brand-secondary font-mono uppercase tracking-tighter opacity-70">Premium Standard</p>
                    </div>
                    {/* Premium */}
                    <div className="glass-card p-4 space-y-2 border-l-4 border-l-orange-400">
                      <div className="text-[10px] font-bold uppercase font-mono text-orange-600">Tier 03: LUXE</div>
                      <div className="text-[11px] font-medium leading-tight">{result?.qualityTiers.premium.materials}</div>
                      <p className="text-[10px] text-brand-secondary font-mono uppercase tracking-tighter opacity-70">High-Performance</p>
                    </div>
                  </div>
                </div>

                {/* Validation Footer */}
                <div className="flex flex-col sm:flex-row gap-4">
                  <div className="flex-1 flex items-center gap-3 p-4 bg-emerald-50 rounded-xl border border-emerald-100">
                    <CheckCircle2 size={24} className="text-emerald-600 shrink-0" />
                    <div>
                      <div className="text-[10px] font-bold text-emerald-800 uppercase tracking-wide">Validation: Compatibility</div>
                      <p className="text-xs text-emerald-700 leading-tight">{result?.validation.compatibilityCheck}</p>
                    </div>
                  </div>
                  <button 
                    onClick={exportToPDF}
                    disabled={isExporting}
                    className="sm:w-auto px-6 py-4 bg-surface-card border border-border-subtle rounded-xl hover:bg-surface-bg transition-colors text-xs font-bold uppercase tracking-widest flex items-center justify-center gap-2 disabled:opacity-50"
                  >
                    {isExporting ? (
                      <Loader2 size={14} className="animate-spin" />
                    ) : (
                      <FileText size={14} />
                    )}
                    {isExporting ? 'Exporting...' : 'Export Techpack'}
                  </button>
                </div>
              </motion.div>
            )}
          </AnimatePresence>
        </section>
      </main>

      <footer className="pt-12 pb-6 text-center text-brand-secondary">
        <p className="text-[10px] font-mono tracking-widest uppercase opacity-40">
          Advanced Predictive Apparel Engine • AI Studio x Cloud Run
        </p>
      </footer>
    </div>
  );
}
