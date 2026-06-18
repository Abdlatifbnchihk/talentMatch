## 1. Enum Creation

- [x] 1.1 Create `Recommendation` enum with Convoquer, Attente, Rejeter cases
- [x] 1.2 Add `label()` method returning human-readable strings
- [x] 1.3 Add `badgeColor()` method returning Tailwind color classes

## 2. Migration

- [x] 2.1 Create migration for `analyses` table with all columns
- [x] 2.2 Add unique index on candidate_id
- [x] 2.3 Add index on matching_score and recommendation columns

## 3. Model

- [x] 3.1 Create `Analysis` model with fillable attributes
- [x] 3.2 Add JSON array casts for extracted_skills, languages, strengths, gaps, missing_skills
- [x] 3.3 Add integer cast for matching_score
- [x] 3.4 Add Recommendation enum cast for recommendation
- [x] 3.5 Add `belongsTo` relationship to Candidate

## 4. Candidate Model Update

- [x] 4.1 Update Candidate model to add `hasMany` relationship to Analysis
- [x] 4.2 Update Candidate model to add `hasOne` relationship for latest analysis
- [x] 4.3 Remove old `hasOne` relationship to CandidateAnalysis if exists