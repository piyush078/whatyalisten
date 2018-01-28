import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { TrackComponent } from './track/track.component';
import { AlbumComponent } from './album/album.component';
import { ArtistComponent } from './artist/artist.component';

const routes: Routes = [
  { path: 'track/:id', component: TrackComponent },
  { path: 'album/:id', component: AlbumComponent },
  { path: 'artist/:id', component: ArtistComponent },
];

@NgModule ({
  imports: [ RouterModule.forRoot (routes) ],
  exports: [ RouterModule ]
})

export class AppRoutingModule {}